<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LimitCommandMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $command = $request->route('command');
        dd($command);

        if ($command === 'app:load-data-into-incomes-table' && Cache::get('my_command_execution_time') !== null) {
            $lastExecutionTime = Carbon::parse(Cache::get('my_command_execution_time'));

            if ($lastExecutionTime->addHour()->isPast(now())) {
                Cache::put('my_command_execution_time', now(), 3600); // Сохраняем время выполнения команды на час
                return $next($request);
            } else {
                abort(403, 'Команда MyCommand уже выполнялась недавно, попробуйте позже.');
            }
        }

        return $next($request);
    }
}
/*namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class LimitMyCommandMiddleware
{
    public function handle($request, Closure $next)
    {
        $command = $request->route('command');

        if ($command === 'MyCommand' && Cache::get('my_command_execution_time') !== null) {
            $lastExecutionTime = Carbon::parse(Cache::get('my_command_execution_time'));

            if ($lastExecutionTime->addHour()->isPast(now())) {
                Cache::put('my_command_execution_time', now(), 3600); // Сохраняем время выполнения команды на час
                return $next($request);
            } else {
                abort(403, 'Команда MyCommand уже выполнялась недавно, попробуйте позже.');
            }
        }

        return $next($request);
    }
}*/

/*public function handle(Request $request, Closure $next): Response
{
    $command = $request->route('command');

    $lastExecutionTime = Cache::get('command_execution_time');

    if ($command === 'LoadDataIntoIncomesTable' && $lastExecutionTime === null || (now()->diffInHours(Carbon::parse($lastExecutionTime)) > 1)) {
        Cache::put('command_execution_time', now(), 3600); // Сохраняем время выполнения команды на час
        return $next($request);
    } else {
        // Команда уже была выполнена менее часа назад, возвращаем ответ об ошибке
        abort(403, 'Команда уже выполнялась недавно, попробуйте позже.');
    }
}*/
