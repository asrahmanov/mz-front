<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Entity\CallbackRequest;
use App\Entity\Doctor;
use App\Entity\DoctorAppointment;
use App\Entity\LetterToDirector;
use App\Entity\QA;
use App\Entity\Review;
use App\Form\LetterToDirectorType;
use App\Form\ArticleCommentType;
use App\Form\CallbackRequestType;
use App\Form\DoctorAppointment2Type;
use App\Form\DoctorQAType;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\ValidationFailedException;

class FormController extends AbstractController
{


    /**
     * @Route("/form/appointment", name="appointment2_form")
     */
    public function appointment(
        Request $request,
        EntityManagerInterface $em,
        Doctor $doctor = null,
        string $template = '_form/_appointment.html.twig'
    )
    {
        $appointment = new DoctorAppointment();
        if ($doctor) {
            $appointment->setDoctor($doctor);
        }

        $form = $this->createForm(DoctorAppointment2Type::class, $appointment);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            try {
                $appointment = $this->processForm($form);
                $messageText = 'Вы успешно записаны к врачу';
                if ($appointment->getDoctor()) {
                    $messageText .= ': ' . $appointment->getDoctor();
                }

                if ($appointment->getDate()) {
                    $messageText .= ' на ' . $appointment->getDate()->format('d.m.Y');
                }

                $messageText .= '.';

                return new JsonResponse([
                    'status' => 'success',
                    'text' => $messageText,
                ]);
            }
            catch (ValidationFailedException $validationFailedException) {
                return $this->validationErrorJsonResponse($validationFailedException->getFormErrors());
            }
        }

        return $this->render($template, [
            'form' => $form->createView(),
            'doctor' => $doctor,
        ]);
    }

    /**
     * @Route("/form/doctor_q_a", name="doctor_q_a_form")
     */
    public function doctorQA(Request $request)
    {
        $form = $this->createForm(DoctorQAType::class, new QA());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                $this->processForm($form);
                return new JsonResponse([
                    'status' => 'success',
                    'text' => 'Спасибо за ваше доверие,<br> мы обязательно свяжемся с вами в ближайшее время!',
                ]);
            }
            catch (ValidationFailedException $validationFailedException) {
                return $this->validationErrorJsonResponse($validationFailedException->getFormErrors());
            }
        }

        return $this->render('_form/_doctor_q_a.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/form/callback", name="callback_request")
     */
    public function callbackRequest(Request $request, string $template = '_form/_callback_request.html.twig')
    {
        $form = $this->createForm(CallbackRequestType::class, new CallbackRequest());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                $this->processForm($form);
                return new JsonResponse([
                    'status' => 'success',
                    'text' => 'Спасибо за ваше доверие,<br> мы обязательно свяжемся с вами в ближайшее время!',
                ]);
            }
            catch (ValidationFailedException $validationFailedException) {
                return $this->validationErrorJsonResponse($validationFailedException->getFormErrors());
            }
        }

        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/form/review", name="review_form")
     */
    public function review(Request $request)
    {
        $form = $this->createForm(ReviewType::class, new Review());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                $this->processForm($form);
                return new JsonResponse([
                    'status' => 'success',
                    'text' => 'Спасибо за ваше доверие,<br> мы обязательно свяжемся с вами в ближайшее время!',
                ]);
            }
            catch (ValidationFailedException $validationFailedException) {
                return $this->validationErrorJsonResponse($validationFailedException->getFormErrors());
            }
        }

        return $this->render('_form/_review.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/form/article_comment", name="article_comment_form")
     */
    public function articleComment(Request $request, ?Article $article = null)
    {
        $comment = new ArticleComment();
        $comment->setArticle($article);
        $form = $this->createForm( ArticleCommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                $this->processForm($form);
                return new JsonResponse([
                    'status' => 'success',
                    'text' => 'Спасибо за ваше доверие,<br> мы обязательно свяжемся с вами в ближайшее время!',
                ]);
            }
            catch (ValidationFailedException $validationFailedException) {
                return $this->validationErrorJsonResponse($validationFailedException->getFormErrors());
            }
        }

        return $this->render('_form/_article_comment.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/form/letter_to_director", name="letter_to_director_form")
     */
    public function letterToDirector(Request $request, ?string $template = '_form/_letter_to_director.html.twig')
    {
        $form = $this->createForm( LetterToDirectorType::class, new LetterToDirector());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                $this->processForm($form);
                return new JsonResponse([
                    'status' => 'success',
                    'text' => 'Спасибо за ваше доверие,<br> мы обязательно свяжемся с вами в ближайшее время!',
                ]);
            }
            catch (ValidationFailedException $validationFailedException) {
                return $this->validationErrorJsonResponse($validationFailedException->getFormErrors());
            }
        }

        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

    private function processForm(FormInterface $form)
    {
        if ($form->isValid()) {
            $entity = $form->getData();
            $this->getDoctrine()->getManager()->persist($entity);
            $this->getDoctrine()->getManager()->flush();
            return $entity;
        }
        throw new ValidationFailedException($form);
    }

    private function validationErrorJsonResponse(array $errors)
    {
        return new JsonResponse([
            'status' => 'validation_fail',
            'data' => $errors,
        ], 400);
    }
}
