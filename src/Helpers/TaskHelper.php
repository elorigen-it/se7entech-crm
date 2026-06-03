<?php
namespace Se7entech\Contractnew\Helpers;
class TaskHelper {
    public static function getTaskStatusLabel($status) {
        switch ($status) {
            case 'started':
                return 'Started';
            case 'paused':
                return 'Paused';
            case 'finished':
                return 'Finished';
            case 'completed':
                return 'Completed';
            default:
                return 'Unknown Status';
        }
    }

    public static function getEstimatedTime($task, $hours = false) {
        if (!$task['estimated_time']) {
            return 0;
        }
        $estimated_time = $task['estimated_time'];
        if ($hours) {
            return ceil($estimated_time / 60);
        }
        return $estimated_time;
    }

    public static function getTotalTime($task, $hours = false) {
        // If the task is finished/completed and has a saved total_time, use it directly!
        if (($task['status'] === 'finished' || $task['status'] === 'completed') && !empty($task['total_time'])) {
            $seconds = (int)$task['total_time'];
            if ($hours) {
                return $seconds / 3600;
            }
            return $seconds;
        }

        // If the task is finished/completed but doesn't have total_time (fallback), use end_time
        $timestamp = time();
        if (($task['status'] === 'finished' || $task['status'] === 'completed') && !empty($task['end_time'])) {
            $timestamp = (int)$task['end_time'];
        }

        if (!$task['start_time']) {
            return 0;
        }

        $start_time = new \DateTime('@'.$task['start_time']);
        
        // 2. Calcular el tiempo total (en segundos)
        $total_seconds = $timestamp - $start_time->getTimestamp();
        
        // 3. Obtener y procesar los intervalos de pausa (ejemplo: "1641000000,1641003600,1641010000,1641012000")
        $paused_intervals = !empty($task['pause_intervals']) ? explode(',', $task['pause_intervals']) : [];
        
        // Si es impar, eliminamos el último timestamp (pausa no finalizada)
        if (count($paused_intervals) % 2 !== 0) {
            array_pop($paused_intervals); // Elimina el último elemento
        }

        // 4. Calcular el tiempo total pausado
        $total_paused = 0;
        for ($i = 0; $i < count($paused_intervals); $i += 2) {
            if (isset($paused_intervals[$i+1])) {
                $total_paused += ($paused_intervals[$i+1] - $paused_intervals[$i]);
            }
        }

        // 5. Calcular el tiempo neto (total - pausas)
        $net_seconds = $total_seconds - $total_paused;        
        if($hours) {
            return $net_seconds / 3600;
        }
        return $net_seconds;       
    }

    public static function getFormattedDeadline($task, $format = 'M d') {
        if (!$task['deadline']) {
            return 'N/A';
        }
        $deadline = new \DateTime('@'.$task['deadline']);
        return $deadline->format($format);
    }

    public static function getRealTotalTime($task, $hours){
        if($task['custom_total_time']){
            if($hours){
                return $task['custom_total_time'] / 60;
            }
            return $task['custom_total_time'];
        }else{
            return self::getTotalTime($task, $hours);
        }
    }
}