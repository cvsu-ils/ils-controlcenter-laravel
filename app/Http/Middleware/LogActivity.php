<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $controller = $this->getController($request);
        $methodName = $this->getMethodName($request);
        $user = Auth::user();

        $properties = array_keys($request->except('_token')); // column names

        if ($controller && $user) {
            $this->logActivityForMethod($controller, $methodName, $user, $properties);
        }

        return $response;
    }

    private function getController(Request $request)
    {
        return optional($request->route())->getController();
    }

    private function getMethodName(Request $request)
    {
        $action = optional($request->route())->getAction();

        return isset($action['controller'])
            ? last(explode('@', $action['controller']))
            : null;
    }

    private function logActivityForMethod($controller, $methodName, $user, $properties)
    {
        foreach ($properties as $property) {
            $controllerName = class_basename($controller);

            switch ($controllerName) {
                case 'ViolationController':
                    switch ($methodName) {
                        case 'store':
                            $this->logActivity("Stored $property via ViolationController", 'Violation Logs', 'Violation', $user, $property);
                            break;
                        case 'update':
                            $this->logActivity("Updated $property via ViolationController", 'Violation Logs', 'Violation', $user, $property);
                            break;
                    }
                    break;
                case 'WifiLogsController':
                    switch ($methodName) {
                        case 'store':
                            $this->logActivity("Stored $property via WifiLogsController", 'Wifi Logs', 'WifiLogs', $user, $property);
                            break;
                    }
                    break;
                case 'InHouseLogsController':
                    switch ($methodName) {
                        case 'store':
                            $this->logActivity("Stored $property via InHouseLogsController", 'Inhouse Logs', 'InHouseLogs', $user, $property);
                            break;
                    }
                    break;
                case 'InHouseClassificationsController':
                    switch ($methodName) {
                        case 'update':
                            $this->logActivity("Edited $property via InHouseClassificationsController", 'Inhouse Classifications Logs', 'InHouseClassifications', $user, $property);
                            break;
                    }
                    break;
            }
        }
    }

    private function logActivity($description, $logName, $subjectType, $user, $property)
    {
        Activity::create([
            'description' => $description,
            'log_name' => $logName,
            'subject_type' => $subjectType,
            'causer_id' => $user->id,
            'causer_type' => get_class($user),
            'properties' => $property, // column name
        ]);
    }
}

