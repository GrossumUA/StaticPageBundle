<?php

namespace Grossum\StaticPageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Grossum\StaticPageBundle\Entity\EntityManager\StaticPageManager;

class StaticPageSelectorType extends AbstractType
{
    /**
     * @var StaticPageManager
     */
    protected $manager;

    /**
     * @param StaticPageManager $manager
     */
    public function __construct(StaticPageManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $that = $this;

        $resolver->setDefaults([
            'btn_add'     => false,
            'choice_list' => function (Options $opts, $previousValue) use ($that) {
                return new SimpleChoiceList($that->getChoices($opts));
            },
        ]);
    }

    /**
     * @param Options $options
     *
     * @return array
     */
    public function getChoices(Options $options)
    {
        $rootStaticPages = $this
            ->manager
            ->getRepository()
            ->childrenHierarchy();

        if (count($rootStaticPages) > 1) {
            throw new \RuntimeException('Wrong number of roots elements. It must be one.');
        }

        $choices = [];

        foreach ($rootStaticPages as $staticPage) {
            $choices[$staticPage['id']] = $staticPage['title'];

            $this->childWalker($staticPage, $options, $choices);
        }

        return $choices;
    }

    /**
     * @param array $staticPage
     * @param Options $options
     * @param array $choices
     * @param int $level
     */
    private function childWalker(array $staticPage, Options $options, array &$choices, $level = 1)
    {
        if (!count($staticPage['__children'])) {
            return;
        }

        foreach ($staticPage['__children'] as $child) {
            $choices[$child['id']] = sprintf('%s %s', str_repeat('-', 2 * $level), $child['title']);

            $this->childWalker($child, $options, $choices, $level + 1);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'sonata_type_model';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'grossum_static_page_static_page_selector';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
