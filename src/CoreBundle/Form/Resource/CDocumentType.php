<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Form\Resource;

use Chamilo\CoreBundle\Form\Type\IllustrationType;
use Chamilo\CourseBundle\Entity\CDocument;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CDocumentType.
 */
class CDocumentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
//            ->add('comment', CKEditorType::class)
            /*->add(
                'shared',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'This course' => 'this_course',
                        'Only me' => 'only_me',
                        'Shared' => 'shared',
                    ),
                    'multiple' => false,
                    'expanded' => true,
                    'required' => true,
                    'mapped' => false,
                )
            )
            ->add(
                'rights',
                CollectionType::class,
                array(
                    'entry_type' => ResourceLinkType::class,
                    'mapped' => false,
                    'allow_add' => true,
                    'by_reference' => false,
                    'allow_delete' => true,
                )
            )*/
            //->add('c_id', HiddenType::class)
            ->add('filetype', HiddenType::class)
            ->add(
                'illustration',
                IllustrationType::class,
                [
                    'label' => 'Illustration',
                    'required' => false,
                    'mapped' => false,
                ]
            )
            /*->add(
                'rights',
                'collection',
                array(
                    'type' => new ResourceRightType(),
                    'mapped' => false,
                    'allow_add' => true,
                )
            )*/
            //->add('resourceNode', new ResourceNodeType())
            ->add('save', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => CDocument::class,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'chamilo_document';
    }
}
