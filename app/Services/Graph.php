<?php

namespace App\Services;


class Graph
{
    private $vertices = [];
    private $edges = [];

    // Добавляем вершину в граф
    public function addVertex($name)
    {
        $this->vertices[$name] = INF; // Инициализируем расстояние до вершины как бесконечность
        $this->edges[$name] = [];
    }

    // Добавляем ребро между двумя вершинами с весом
    public function addEdge($start, $end, $weight)
    {
        $this->edges[$start][$end] = $weight;
        $this->edges[$end][$start] = $weight; // Для неориентированного графа
    }

    // Алгоритм Дейкстры для поиска кратчайших путей от исходной вершины
    public function dijkstra($source)
    {
        // Инициализация
        $distances = $this->vertices; // Копируем массив вершин
        $distances[$source] = 0; // Расстояние до исходной вершины — 0
        $visited = []; // Посещённые вершины
        $previous = []; // Массив предыдущих вершин для восстановления пути

        while (count($visited) < count($this->vertices)) {
            // Находим непосещённую вершину с минимальным расстоянием
            $minVertex = null;
            foreach ($distances as $vertex => $distance) {
                if (!isset($visited[$vertex]) && ($minVertex === null || $distance < $distances[$minVertex])) {
                    $minVertex = $vertex;
                }
            }

            if ($minVertex === null) {
                // Все оставшиеся вершины недостижимы
                break;
            }

            // Отмечаем текущую вершину как посещённую
            $visited[$minVertex] = true;

            // Обновляем расстояния до соседей
            foreach ($this->edges[$minVertex] as $neighbor => $weight) {
                if (!isset($visited[$neighbor])) {
                    $newDistance = $distances[$minVertex] + $weight;

                    // Обновляем расстояние до соседа, если оно меньше текущего
                    if ($newDistance < $distances[$neighbor]) {
                        $distances[$neighbor] = $newDistance;
                        $previous[$neighbor] = $minVertex;
                    }
                }
            }
        }

        return [$distances, $previous]; // Возвращаем массив расстояний и предыдущих вершин
    }

    // Восстановление пути до целевой вершины
    public function getPath($previous, $target)
    {
        $path = [];
        while (isset($previous[$target])) {
            $path[] = $target;
            $target = $previous[$target];
        }
        $path[] = $target; // Добавляем стартовую вершину
        return array_reverse($path); // Возвращаем путь в правильном порядке
    }
}
