<?php

namespace Phalcon\Docs;

class RstTableTest extends TestCase
{
    function setUp()
    {
        $this->table = new RstTable();
    }
    
    function test_renderEmptyTable()
    {
        $this->setExpectedException('RuntimeException', 'no header');
        $this->table->render();
    }
    
    function test_renderOnlyHeaderTable()
    {
        $this->setExpectedException('RuntimeException', 'no record');
        $this->table->setHeader(array('Column A', 'Column B'));
        $this->table->render();
    }
    
    function test_renderNormalTableWithOneRecord()
    {
        $this->table->setHeader(array('Column A', 'Column B', 'Column C'));
        $this->table->addRecord(array('Item A', 'Item B', 'Item C'));
        $test = $this->table->render();
        $expected = <<<'EOL'
+----------+----------+----------+
| Column A | Column B | Column C |
+==========+==========+==========+
| Item A   | Item B   | Item C   |
+----------+----------+----------+


EOL;
        $this->assertEquals($expected, $test);
    }
    
    function test_renderNormalTableWithEmptyItem()
    {
        $this->table->setHeader(array('Column A', 'Column B', 'Column C'));
        $this->table->addRecord(array('Item A', 'Item B', ''));
        $test = $this->table->render();
        $expected = <<<'EOL'
+----------+----------+----------+
| Column A | Column B | Column C |
+==========+==========+==========+
| Item A   | Item B   |          |
+----------+----------+----------+


EOL;
        $this->assertEquals($expected, $test);
    }
    
    function test_renderNormalTableWithTwoRecords()
    {
        $this->table->setHeader(array('Column A', 'Column B', 'Column C'));
        $this->table->addRecord(array('Item A', 'Item B', 'Item C'));
        $this->table->addRecord(array('Item A', 'Item B', 'Item C'));
        $test = $this->table->render();
        $expected = <<<'EOL'
+----------+----------+----------+
| Column A | Column B | Column C |
+==========+==========+==========+
| Item A   | Item B   | Item C   |
+----------+----------+----------+
| Item A   | Item B   | Item C   |
+----------+----------+----------+


EOL;
        $this->assertEquals($expected, $test);
    }
}
