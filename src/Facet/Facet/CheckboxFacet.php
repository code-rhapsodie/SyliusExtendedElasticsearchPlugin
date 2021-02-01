<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Facet;

use Elastica\Aggregation\AbstractAggregation;
use Elastica\Aggregation\Terms as TermsAggregate;
use Elastica\Query\AbstractQuery;
use Elastica\Query\BoolQuery;
use Elastica\Query\Terms as TermsQuery;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class CheckboxFacet extends AbstractFacet
{
    /** @var array */
    private $choiceLabels;

    /** @var string */
    private $label;

    public function __construct(string $fieldName, array $choiceLabels, string $label)
    {
        parent::__construct($fieldName);

        $this->choiceLabels = $choiceLabels;
        $this->label = $label;
    }

    public function getQuery($data): AbstractQuery
    {
        return new TermsQuery($this->fieldName, $data);
    }

    public function getFormType(): string
    {
        return ChoiceType::class;
    }

    public function getFormOptions(array $data): array
    {
        $choices = [];
        foreach ($data['buckets'] as $bucket) {
            $key = $bucket['key'];
            $label = sprintf('%s (%s)', $this->choiceLabels[$key] ?? $key, $bucket['doc_count']);
            $choices[$label] = $key;
        }

        return [
            'choices' => $choices,
            'multiple' => true,
            'expanded' => true,
            'label' => $this->label,
        ];
    }

    protected function createAggregation(): AbstractAggregation
    {
        return (new TermsAggregate($this->fieldName))
            ->setField($this->fieldName.'.keyword')
        ;
    }
}
