<?php

namespace kosssi\MyAlbumsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Type for update album name
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class AlbumNameType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->setMethod('PATCH');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'kosssi\MyAlbumsBundle\Entity\Image',
            'validation_groups' => array('name'),
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'album_name';
    }
}
