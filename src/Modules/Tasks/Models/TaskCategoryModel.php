<?php

namespace Se7entech\Contractnew\Modules\Tasks\Models;

use Se7entech\Contractnew\Helpers\EscapeString;

class TaskCategoryModel {
    private static $table = 'task_categories';
    private static $taskCategoriesTasks = 'task_categories_tasks';

    // Get all categories
    public static function getAll() {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT id, name, description FROM " . self::$table . " ORDER BY id ASC";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }
        return $response;
    }

    // Get category by id
    public static function getById($id) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT id, name, description FROM " . self::$table . " WHERE id='" . intval($id) . "'";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }
        return $response;
    }

    // Create a new category
    public static function postCategory($data) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table . " (name, description) VALUES ('" . $data['category-name'] . "', '" . $data['category-description'] . "')";
        $result = mysqli_query($con, $sql);
        return array('success' => $result, 'id' => mysqli_insert_id($con));
    }

    // Update a category
    public static function updateCategory($id, $data) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET name='" . $data['category-name'] . "', description='" . $data['category-description'] . "' WHERE id=" . intval($id);
        return (mysqli_query($con, $sql));
    }

    // Delete a category and its associations in task_categories_tasks
    public static function delete($id) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        // Delete associations in task_categories_tasks
        $sqlAssoc = "DELETE FROM " . self::$taskCategoriesTasks . " WHERE category_id=" . intval($id);
        mysqli_query($con, $sqlAssoc);

        // Delete the category itself
        $sql = "DELETE FROM " . self::$table . " WHERE id=" . intval($id);
        $res = mysqli_query($con, $sql);

        return $res;
    }

    // Get all categories for a specific task
    public static function getCategoriesByTaskId($taskId) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT c.id, c.name, c.description FROM " . self::$taskCategoriesTasks . " tct
                JOIN " . self::$table . " c ON tct.category_id = c.id
                WHERE tct.task_id = " . intval($taskId);
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }
        return $response;
    }

    // Assign a category to a task
    public static function assignCategoryToTask($taskId, $categoryId) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $sql = "INSERT INTO " . self::$taskCategoriesTasks . " (task_id, category_id) VALUES (" . intval($taskId) . ", " . intval($categoryId) . ")";
        return mysqli_query($con, $sql);
    }

    // Remove a category from a task
    public static function removeCategoryFromTask($taskId, $categoryId) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $sql = "DELETE FROM " . self::$taskCategoriesTasks . " WHERE task_id=" . intval($taskId) . " AND category_id=" . intval($categoryId);
        return mysqli_query($con, $sql);
    }
}
