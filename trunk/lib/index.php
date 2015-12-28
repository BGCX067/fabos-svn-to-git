<?php
function index()
{
    echo date('Y-m-d H:i:s');

    App::setVar('name', 'caleng');
    App::display();
}

function show($i, $j)
{
    echo $j+$i;
    App::setVar('name', 'tcm');
    App::display('index');
}

function test()
{
    echo 13123;
}

class index
{
    public function GET()
    {
        echo __METHOD__;
    }

    public function POST()
    {
        echo __METHOD__;
    }

    public function PUT()
    {
        echo __METHOD__;
    }

    public function DELETE()
    {
        echo __METHOD__;
    }
}