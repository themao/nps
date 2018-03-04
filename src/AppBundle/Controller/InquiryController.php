<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Inquiry;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class InquiryController extends Controller
{
    /**
     * @param Request $request
     * @param Product $product
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $product, $type = '')
    {
        return $this->render('AppBundle:Inquiry:index.html.twig', [
            'product' => $product,
            'type' => $type,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendAction(Request $request)
    {
        $inquiry = new Inquiry();
        $inquiry->setEmail($request->get('email'))
                ->setProduct($request->get('product'))
                ->setText($request->get('text'))
                ->setLocale($request->get('locale'))
                ->setClientIp($request->getClientIp());

        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();
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
            $inquiry->getText());
        $message = \Swift_Message::newInstance()
            ->setSubject("Новий запит для {$inquiry->getProduct()}!")
            ->setFrom($this->getParameter('from_email'))
            ->setTo($this->getParameter('admin_email'))
            ->setCc($this->getParameter('cc_email'))
            ->setBody(
                $body,
                'text/html'
            );
        $this->get('mailer')->send($message);

        return new JsonResponse(true);
    }
}
