<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    const SESSION_KEY = 'CART_SESSION_KEY';

    /**
     * @Route("/prepare", name="prepare")
     */
    public function prepareAction(Request $request)
    {
        $cart = new Cart();
        $request->getSession()->set(self::SESSION_KEY, $cart);

        return $this->redirectToRoute('enjoy_shopping');
    }

    /**
     * @Route("/enjoy_shopping", name="enjoy_shopping")
     */
    public function enjoyShoppingAction(Request $request)
    {
        return $this->render(
            '/cart/enjoy_shopping.html.twig',
            ['cart' => $request->getSession()->get(self::SESSION_KEY)]);
    }

    /**
     * @Route("/buy_product/{product}", name="buy_product")
     */
    public function buyProductAction(Request $request, $product)
    {
        $cart = $request->getSession()->get(self::SESSION_KEY);
        $cart->addProduct($product);

        $this->addFlash('notice', $product . 'をカートに入れました。');

        return $this->redirectToRoute('enjoy_shopping');
    }

    /**
     * @Route("/remove_product/{index}", name="remove_product")
     */
    public function removeProductAction(Request $request, $index)
    {
        $cart = $request->getSession()->get(self::SESSION_KEY);
        $product = $cart->getProducts()[$index];
        $cart->removeProduct($index);

        $this->addFlash('notice', $product . 'をカートから削除しました。');

        return $this->redirectToRoute('enjoy_shopping');
    }

    /**
     * @Route("/confirm", name="confirm")
     */
    public function confirmAction(Request $request)
    {
        $cart = $request->getSession()->get(self::SESSION_KEY);

        $this->get('workflow.cart')->apply($cart, 'confirm');

        return $this->render(
            '/cart/confirm.html.twig',
            ['cart' => $request->getSession()->get(self::SESSION_KEY)]);
    }

    /**
     * @Route("/back", name="back")
     */
    public function backAction(Request $request)
    {
        $cart = $request->getSession()->get(self::SESSION_KEY);

        $this->get('workflow.cart')->apply($cart, 'back');

        return $this->redirectToRoute('enjoy_shopping');
    }

    /**
     * @Route("/complete", name="complete")
     */
    public function completeAction(Request $request)
    {
        $cart = $request->getSession()->get(self::SESSION_KEY);

        $this->get('workflow.cart')->apply($cart, 'complete');

        return $this->render(
            '/cart/complete.html.twig',
            ['cart' => $request->getSession()->get(self::SESSION_KEY)]);
    }
}
