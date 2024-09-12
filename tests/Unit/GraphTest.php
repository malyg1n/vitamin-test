<?php

namespace Tests\Unit;

use App\Services\Graph;
use Tests\TestCase;

class GraphTest extends TestCase
{
    // Тест на корректность вычисления кратчайших расстояний
    public function testDijkstraShortestDistances()
    {
        // Создаем граф
        $graph = new Graph();

        // Добавляем вершины
        $graph->addVertex('A');
        $graph->addVertex('B');
        $graph->addVertex('C');
        $graph->addVertex('D');
        $graph->addVertex('E');

        // Добавляем ребра
        $graph->addEdge('A', 'B', 4);
        $graph->addEdge('A', 'C', 1);
        $graph->addEdge('C', 'B', 2);
        $graph->addEdge('B', 'D', 5);
        $graph->addEdge('C', 'D', 8);
        $graph->addEdge('C', 'E', 10);
        $graph->addEdge('D', 'E', 2);

        // Выполняем алгоритм Дейкстры от вершины A
        list($distances, $previous) = $graph->dijkstra('A');

        // Проверяем кратчайшие расстояния
        $this->assertEquals(0, $distances['A']);
        $this->assertEquals(3, $distances['B']);
        $this->assertEquals(1, $distances['C']);
        $this->assertEquals(8, $distances['D']);
        $this->assertEquals(10, $distances['E']);
    }

    // Тест на восстановление кратчайшего пути
    public function testGetShortestPath()
    {
        // Создаем граф
        $graph = new Graph();

        // Добавляем вершины
        $graph->addVertex('A');
        $graph->addVertex('B');
        $graph->addVertex('C');
        $graph->addVertex('D');
        $graph->addVertex('E');

        // Добавляем ребра
        $graph->addEdge('A', 'B', 4);
        $graph->addEdge('A', 'C', 1);
        $graph->addEdge('C', 'B', 2);
        $graph->addEdge('B', 'D', 5);
        $graph->addEdge('C', 'D', 8);
        $graph->addEdge('C', 'E', 10);
        $graph->addEdge('D', 'E', 2);

        // Выполняем алгоритм Дейкстры от вершины A
        list($distances, $previous) = $graph->dijkstra('A');

        // Проверяем путь до вершины E
        $path = $graph->getPath($previous, 'E');
        $this->assertEquals(['A', 'C', 'B', 'D', 'E'], $path);
    }
}
