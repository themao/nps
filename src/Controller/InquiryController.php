<?php

namespace App\Controller;

use App\Entity\Inquiry;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class InquiryController extends AbstractController
{
    /**
     * @param array|\App\Entity\Product $product
     */
    public function indexAction($product, string $type = ''): Response
    {
        return $this->render('Inquiry/index.html.twig', [
            'product' => $product,
            'type' => $type,
        ]);
    }

    public function sendAction(
        Request $request,
        EntityManagerInterface $manager,
        MailerInterface $mailer,
        LoggerInterface $logger,
        #[Autowire('%env(FROM_EMAIL)%')] string $fromEmail,
        #[Autowire('%env(ADMIN_EMAIL)%')] string $adminEmail,
        #[Autowire('%env(CC_EMAIL)%')] string $ccEmail,
    ): JsonResponse {
        $inquiry = new Inquiry();
        $inquiry->setEmail($request->request->get('email'))
                ->setProduct($request->request->get('product'))
                ->setText($request->request->get('text'))
                ->setLocale($request->request->get('locale'))
                ->setClientIp($request->getClientIp());

        $manager->persist($inquiry);
        $manager->flush();

        $body = sprintf(
            'Продукт: %s<br>
            E-mail: %s<br>
            IP: %s<br>
            Текст запиту: %s<br>',
            $inquiry->getProduct(),
            $inquiry->getEmail(),
            $inquiry->getClientIp(),
            $inquiry->getText()
        );

        if (strlen((string) $inquiry->getText()) < 40 && (!str_contains((string) $inquiry->getText(), ' ') || !str_contains((string) $inquiry->getText(), ','))) {
            return new JsonResponse('Error', 400);
        }

        try {
            $message = (new Email())
                ->subject("Новий запит для {$inquiry->getProduct()}!")
                ->from($fromEmail)
                ->to($adminEmail)
                ->cc($ccEmail)
                ->html($body);
            $mailer->send($message);
        } catch (\Exception $e) {
            $logger->critical($e->getMessage());
        }

        return new JsonResponse(true);
    }
}
