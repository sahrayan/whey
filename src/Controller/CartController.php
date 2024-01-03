<?php

namespace App\Controller;

use App\Repository\ProductRepository; // Assurez-vous d'importer le ProductRepository
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $cart = $session->get('cart', []);  // Assurez-vous que $cart est initialisé
        $cartWithData = [];
    
        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            if (!$product) {
                continue; // Skip if the product does not exist
            }
    
            $choose = $product->getChoose();
            $price = $choose ? $choose->getPrice() : 0;
    
            $cartWithData[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price
            ];
        }
    
        $total = 0;
        foreach ($cartWithData as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    
        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }
    

    // Ajouter un produit au panier
    #[Route('/cart/add/{id}', name: 'cart_add')]
public function add($id, SessionInterface $session, ProductRepository $productRepository)
{
    // Récupérer le panier actuel de la session, ou initialiser à vide si aucun panier n'existe
    $cart = $session->get('cart', []);

    // Vérifier si le produit existe pour éviter des problèmes
    if ($productRepository->find($id)) {
        // Ajouter ou incrémenter le produit dans le panier
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
    } else {
        // Gérer l'erreur si le produit n'existe pas (redirection, message flash, etc.)
        // ...
        return $this->redirectToRoute('product_index');
    }

    // Sauvegarder le panier mis à jour dans la session
    $session->set('cart', $cart);

    // Rediriger vers une page (par exemple, la page du panier)
    return $this->redirectToRoute('cart_index');
}
    // Supprimer un produit du panier
    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    // Valider le panier (procéder au paiement)
    #[Route('/cart/checkout', name: 'cart_checkout')]
    public function checkout(SessionInterface $session)
    {
        // Ici, vous intégreriez avec votre système de paiement
        // Par exemple, créer une charge avec Stripe ou PayPal
        // Après le paiement, vous pourriez vider le panier et rediriger l'utilisateur

        // Supposons que le paiement a réussi
        $session->set('cart', []); // Vide le panier

        // Redirige vers une page de confirmation ou retour à l'accueil
        return $this->redirectToRoute('app_home');
    }
    // Pour augmenter la quantité
#[Route('/cart/increase/{id}', name: 'cart_increase')]
public function increase($id, SessionInterface $session)
{
    $cart = $session->get('cart', []);

    if (!empty($cart[$id])) {
        $cart[$id]++;
    }

    $session->set('cart', $cart);

    return $this->redirectToRoute('cart_index');
}

// Pour diminuer la quantité
#[Route('/cart/decrease/{id}', name: 'cart_decrease')]
public function decrease($id, SessionInterface $session)
{
    $cart = $session->get('cart', []);

    if (!empty($cart[$id]) && $cart[$id] > 1) { // Assurez-vous que la quantité ne devienne pas négative
        $cart[$id]--;
    } else {
        unset($cart[$id]); // Si la quantité devient 1, puis 0, supprimez le produit du panier
    }

    $session->set('cart', $cart);

    return $this->redirectToRoute('cart_index');
}
}
