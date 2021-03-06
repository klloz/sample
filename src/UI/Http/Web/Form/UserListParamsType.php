<?php

namespace App\UI\Http\Web\Form;

use App\Application\User\Query\UserList\UserListParams;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserListParamsType
 */
class UserListParamsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registeredSince', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    3 => new DateTime('-3 day'),
                    7 => new DateTime('-1 week'),
                    30 => new DateTime('-30 day')
                ],
                'required' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserListParams::class
        ]);
    }
}
