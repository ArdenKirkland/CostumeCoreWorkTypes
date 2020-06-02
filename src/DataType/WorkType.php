<?php
namespace CostumeCoreWorkTypes\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Api\Representation\ValueRepresentation;
use Omeka\DataType\Uri;
use Omeka\Entity\Value;
use Zend\Form\Element\Select;
use Zend\View\Renderer\PhpRenderer;

class WorkType extends Uri
{
    /**
     * @var array
     */
    protected $statements = [
        'http://vocab.getty.edu/aat/300251645' => 'accessory',
        'http://vocab.getty.edu/aat/300198926' => 'bag',
        'http://www.wikidata.org/entity/Q890119' => 'bodysuit',
        'http://vocab.getty.edu/aat/300046140' => 'cape',
        'http://vocab.getty.edu/aat/300046143' => 'coat',
        'http://vocab.getty.edu/aat/300046159' => 'dress',
        'http://vocab.getty.edu/aat/300209844' => 'ensemble',
        'http://vocab.getty.edu/aat/300209280' => 'footwear',
        'http://vocab.getty.edu/aat/300148821' => 'gloves',
        'http://vocab.getty.edu/aat/300209285' => 'headwear',
        'http://vocab.getty.edu/aat/300046167' => 'jacket',
        'http://vocab.getty.edu/aat/300209286' => 'jewelry',
        'http://vocab.getty.edu/aat/300209984' => 'legwear',
        'http://vocab.getty.edu/aat/300260366' => 'overalls',
        'http://vocab.getty.edu/aat/300220740' => 'pants',
        'http://vocab.getty.edu/aat/300209852' => 'robe',
        'http://vocab.getty.edu/aat/300209991' => 'shawl',
        'http://vocab.getty.edu/aat/300209930' => 'shorts',
        'http://vocab.getty.edu/aat/300209932' => 'skirt',
        'http://vocab.getty.edu/aat/300209863' => 'suit',
        'http://vocab.getty.edu/aat/300209900' => 'sweater',
        'http://vocab.getty.edu/aat/300411736' => 'top',
        'http://vocab.getty.edu/aat/300209267' => 'underwear',
        'http://vocab.getty.edu/aat/300209904' => 'vest',
    ];

    public function getName()
    {
        return 'work_type';
    }

    public function getLabel()
    {
        return 'Costume Core Work Types';
    }

    public function form(PhpRenderer $view)
    {
        $select = new Select('work-type');
        $select
            ->setAttribute('data-value-key', '@id')
            ->setEmptyOption('Select Below')
            ->setValueOptions($this->statements);
        return $view->formSelect($select);

    }

    public function isValid(array $valueObject)
    {
        return parent::isValid($valueObject) && isset($this->statements[$valueObject['@id']]);
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $uri = $valueObject['@id'];
        if (isset($this->statements[$uri])) {
            $valueObject['o:label'] = $this->statements[$uri];
        }
        parent::hydrate($valueObject, $value, $adapter);
    }

    public function render(PhpRenderer $view, ValueRepresentation $value)
    {
        $hyperlink = $view->plugin('hyperlink');
        $escape = $view->plugin('escapeHtml');

        $uri = $value->uri();
        $uriLabel = $value->value();
        $content = $escape($uriLabel);
        
        return $hyperlink->raw($content, $uri, ['class' => 'work-types-link']);
    }
}
