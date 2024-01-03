<?php
// src/Form/ProductType.php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;        
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('stock', IntegerType::class)
            ->add('volume', IntegerType::class)
            ->add('benefits', TextareaType::class)
            ->add('imgProduct', TextType::class)
            ->add('nutritionalPropreties', TextareaType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ]) // Assuming Category entity has a 'name' field
                // Other options can be set here, such as 'multiple' for a many-to-many relationship
        
            // Add more fields or customize as needed
            ;   
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ensure that category is set
            if (!$product->getCategory()) {
                // Handle the error, e.g., add a flash message or throw an exception
            }

            $entityManager->persist($product);
            $entityManager->flush();

            // Redirect or return response
        }

        // Return form view
    }
}
