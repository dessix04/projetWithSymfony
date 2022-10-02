<?php 
namespace App\Controller;
 
use App\Entity\StoreFile;
use App\Form\StoreFileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Persistence\ManagerRegistry;
 
class UploadController extends AbstractController
{
  /**
   * @Route("/store_file", name="store_file")
   */
  public function storeFile(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
  {
    $doc_db = $doctrine->getManager();
    $sf = new StoreFile();
    $form = $this->createForm(StoreFileType::class, $sf);
    $form->handleRequest($request);
 
    if ($form->isSubmitted() && $form->isValid()) {
      /** @var UploadedFile $ storeFileData */
      $storeFileData = $form->get('path')->getData();
 
      // this condition is needed because the 'path' field is not required
      // so the PDF file must be processed only when a file is uploaded
      if ($storeFileData) {
        $originalFilename = pathinfo($storeFileData->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$storeFileData->guessExtension();
 
        // Move the file to the directory where files are stored
        try {
          $storeFileData->move(
            $this->getParameter('upload_directory'),
            $newFilename
          );
        } catch (FileException $e) {
          // ... handle exception if something happens during file upload
        }
 
        // updates the 'storeFileData name' property to store the PDF file name
        // instead of its contents
        $sf->setPath($newFilename);
        $doc_db->persist($sf);
        //unset($v);
        $doc_db->flush();
      }
 
      // ... persist the $product variable or any other work
 
      return $this->redirectToRoute('list_files', ['lastInsert' => $newFilename]);
    }
 
    return $this->renderForm('upload/formUpload.html.twig', [
      'form' => $form,
    ]);
  }
 
  /**
   * @Route("/list_files/{lastInsert}", name="list_files", defaults={"lastInsert": ""})
   */
  public function listFiles(ManagerRegistry $doctrine, string $lastInsert): Response
  {
    $tbl = $doctrine->getRepository(StoreFile::class);
    foreach($tbl->findAll() as $line) {
      $results[] = [
        'comment' => $line->getComment(),
        'path'    => $line->getPath(),
      ];
    }
 
    return $this->render('upload/uploadDone.html.twig', [
      'lastFile' => $lastInsert,
      'results' => $results,
    ]);
  }
}
