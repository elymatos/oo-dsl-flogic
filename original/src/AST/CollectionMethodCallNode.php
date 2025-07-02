<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

class CollectionMethodCallNode extends ExpressionNode
{
    public string $collection;
    public string $method;
    public array $arguments;

    public function __construct(string $collection, string $method, array $arguments = [], ?SourceLocation $location = null)
    {
        parent::__construct($location);
        $this->collection = $collection;
        $this->method = $method;
        $this->arguments = $arguments;
    }

    public function generateFLogic(): string
    {
        switch ($this->method) {
            case 'count':
            case 'size':
                return "|{$this->collection}|";
            case 'sum':
                return "sum{\$Val | {$this->collection} -> \$Item, \$Item -> \$Val}";
            case 'max':
                return "max{\$Val | {$this->collection} -> \$Item, \$Item -> \$Val}";
            case 'min':
                return "min{\$Val | {$this->collection} -> \$Item, \$Item -> \$Val}";
            case 'first':
                return "first{\$Item | {$this->collection} -> \$Item}";
            case 'last':
                return "last{\$Item | {$this->collection} -> \$Item}";
            default:
                throw new \Exception("Unsupported collection method: {$this->method}");
        }
    }

    public function __toString(): string
    {
        return "{$this->collection}.{$this->method}()";
    }
}