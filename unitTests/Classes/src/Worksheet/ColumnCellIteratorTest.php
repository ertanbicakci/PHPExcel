<?php

namespace PHPExcel\Worksheet;

class ColumnCellIteratorTest extends \PHPUnit_Framework_TestCase
{
    public $mockWorksheet;
    public $mockColumnCell;

    public function setUp()
    {
        $this->mockCell = $this->getMockBuilder('\\PHPExcel\\Cell')
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockWorksheet = $this->getMockBuilder('\\PHPExcel\\Worksheet')
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockWorksheet->expects($this->any())
                 ->method('getHighestRow')
                 ->will($this->returnValue(5));
        $this->mockWorksheet->expects($this->any())
                 ->method('getCellByColumnAndRow')
                 ->will($this->returnValue($this->mockCell));
    }


    public function testIteratorFullRange()
    {
        $iterator = new ColumnCellIterator($this->mockWorksheet, 'A');
        $ColumnCellIndexResult = 1;
        $this->assertEquals($ColumnCellIndexResult, $iterator->key());
        
        foreach ($iterator as $key => $ColumnCell) {
            $this->assertEquals($ColumnCellIndexResult++, $key);
            $this->assertInstanceOf('\\PHPExcel\\Cell', $ColumnCell);
        }
    }

    public function testIteratorStartEndRange()
    {
        $iterator = new ColumnCellIterator($this->mockWorksheet, 'A', 2, 4);
        $ColumnCellIndexResult = 2;
        $this->assertEquals($ColumnCellIndexResult, $iterator->key());
        
        foreach ($iterator as $key => $ColumnCell) {
            $this->assertEquals($ColumnCellIndexResult++, $key);
            $this->assertInstanceOf('\\PHPExcel\\Cell', $ColumnCell);
        }
    }

    public function testIteratorSeekAndPrev()
    {
        $iterator = new ColumnCellIterator($this->mockWorksheet, 'A', 2, 4);
        $columnIndexResult = 4;
        $iterator->seek(4);
        $this->assertEquals($columnIndexResult, $iterator->key());

        for ($i = 1; $i < $columnIndexResult-1; $i++) {
            $iterator->prev();
            $this->assertEquals($columnIndexResult - $i, $iterator->key());
        }
    }

    /**
     * @expectedException \PHPExcel\Exception
     */
    public function testSeekOutOfRange()
    {
        $iterator = new ColumnCellIterator($this->mockWorksheet, 'A', 2, 4);
        $iterator->seek(1);
    }

    /**
     * @expectedException \PHPExcel\Exception
     */
    public function testPrevOutOfRange()
    {
        $iterator = new ColumnCellIterator($this->mockWorksheet, 'A', 2, 4);
        $iterator->prev();
    }
}
