<?php

namespace Freesewing\Tests;

use \Freesewing\Utils;

class UtilsTest extends \PHPUnit\Framework\TestCase
{
    private function loadTemplate($template)
    {
        $dir = 'tests/src/fixtures';
        return file_get_contents("$dir/Utils.$template.txt");
    }

    /**
     * Tests the asScrubbedArray method
     */
    public function testAsScrubbedArray()
    {
        $in = 'The quick brown    fox ';
        $out = [
            'The',
            'quick',
            'brown',
            'fox',
        ];
        
        $this->assertEquals(Utils::asScrubbedArray($in), $out);
        $this->assertEquals(Utils::asScrubbedArray('   '), false);
    }
    
    /**
     * Tests the isAllowedPathCommend method
     */
    public function testIsAllowedPathCommand()
    {
        $this->assertEquals(Utils::isAllowedPathCommand('M'), true);
        $this->assertEquals(Utils::isAllowedPathCommand('L'), true);
        $this->assertEquals(Utils::isAllowedPathCommand('C'), true);
        $this->assertEquals(Utils::isAllowedPathCommand('Z'), true);
        $this->assertEquals(Utils::isAllowedPathCommand('z'), true);
        $this->assertEquals(Utils::isAllowedPathCommand('A'), false);
    }
    
    /**
     * Tests the flattenAttributes method
     */
    public function testFlattenAttributes()
    {
        $in = [
            'class' => 'helpline',
            'dx' => 12,
        ];
        $out = 'class="helpline" dx="12" ';
        $this->assertEquals(Utils::flattenAttributes($in), $out);
        $this->assertEquals(Utils::flattenAttributes($out), false);
    }
    
    /**
     * Tests the bezierPoint method
     */
    public function testBezierPoint()
    {
        $this->assertEquals(Utils::bezierPoint(0.7,10,20,80,90), 70.200000000000003);
    }
    
    /**
     * Tests the getClassDir method
     */
    public function testGetClassDir()
    {
        $dir = dirname(dirname(__DIR__));
        $this->assertEquals(Utils::getClassDir(new \Freesewing\Context), "$dir/src/Context");
    }
    
    /**
     * Tests the findLineLineIntersection method
     */
    public function testFindLineLineIntersection()
    {
        $p1 = new \Freesewing\Point();
        $p2 = new \Freesewing\Point();
        $p3 = new \Freesewing\Point();
        $p4 = new \Freesewing\Point();

        $p1->setX(0);
        $p1->setY(0);
        $p2->setX(100);
        $p2->setY(100);
        $p3->setX(100);
        $p3->setY(0);
        $p4->setX(0);
        $p4->setY(100);
        $this->assertEquals(Utils::findLineLineIntersection($p2,$p1,$p3,$p4), [50,50]);
        $this->assertEquals(Utils::findLineLineIntersection($p1,$p3,$p2,$p4), false);
        $this->assertEquals(Utils::findLineLineIntersection($p1,$p4,$p2,$p3), false);
    }
    
    /**
     * Tests the findLineLineIntersection method for a vertical line
     */
    public function testFindLineLineIntersectionVertical()
    {
        $p1 = new \Freesewing\Point();
        $p2 = new \Freesewing\Point();
        $p3 = new \Freesewing\Point();
        $p4 = new \Freesewing\Point();

        $p1->setX(0);
        $p1->setY(0);
        $p2->setX(100);
        $p2->setY(100);
        $p3->setX(50);
        $p3->setY(0);
        $p4->setX(50);
        $p4->setY(100);
        $this->assertEquals(Utils::findLineLineIntersection($p1,$p2,$p3,$p4), [50,50]);
        $this->assertEquals(Utils::findLineLineIntersection($p3,$p4,$p1,$p2), [50,50]);
    }
    
    /**
     * Tests the isSamePoint method
     */
    public function testIsSamePoint()
    {
        $p1 = new \Freesewing\Point();
        $p2 = new \Freesewing\Point();
        
        $p1->setX(10);
        $p1->setY(20);
        $p2->setX(10.0001);
        $p2->setY(19.999992);
        $this->assertEquals(Utils::isSamePoint($p1,$p2), true);
        $p2->setY(19.9);
        $this->assertEquals(Utils::isSamePoint($p1,$p2), false);

    }
    
    /**
     * Tests the distance method
     */
    public function testDistance()
    {
        $p1 = new \Freesewing\Point();
        $p2 = new \Freesewing\Point();
        
        $p1->setX(0);
        $p1->setY(0);
        $p2->setX(100);
        $p2->setY(0);
        $this->assertEquals(Utils::distance($p1,$p2), 100);
        $p2->setY(100);
        $this->assertEquals(Utils::distance($p1,$p2), 141.42135623730951);

    }
    
    /**
     * Tests the debug method
     */
    public function testDebug()
    {
        $this->assertEquals(Utils::debug('test'), $this->loadTemplate('debug'));
    }
    
    /**
     * Tests the slug method
     */
    public function testSlug()
    {
        $this->assertEquals(Utils::slug('Man, I could murder an ice-cream right now'), 'Man-I-could-murder-an-ice-cream-right-now');
    }
}
