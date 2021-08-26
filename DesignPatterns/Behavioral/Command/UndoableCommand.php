<?php

namespace DesignPatterns\Behavioral\Command;

interface UndoableCommand extends Command
{
    public function undo();
}