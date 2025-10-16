<?php
namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Username', TextType::class, ['label'=>'username'])
            ->add('email', TextType::class, ['label'=>'Email'])
            ->add('save', SubmitType::class, ['label'=>'Ajouter l\'auteur']);
    }
}
