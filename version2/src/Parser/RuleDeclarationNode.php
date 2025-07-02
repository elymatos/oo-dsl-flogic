<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;


/**
 * Rule declaration node
 */
class RuleDeclarationNode extends ASTNode
{
    private string $name;
    private ConditionNode $condition;
    private ActionNode $action;

    public function __construct(string $name, ConditionNode $condition, ActionNode $action)
    {
        parent::__construct();
        $this->name = $name;
        $this->condition = $condition;
        $this->action = $action;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCondition(): ConditionNode
    {
        return $this->condition;
    }

    public function getAction(): ActionNode
    {
        return $this->action;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitRuleDeclaration($this);
    }
}
