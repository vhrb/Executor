<?php
namespace Vhrb\Executor\Command;

use Nette\Utils\DateTime;
use Vhrb\Executor\ExecuteCommandException;

class Executor implements IExecutor
{

	/** @var  DateTime */
	protected $runDate;

	public function run(Request $request)
	{
		$this->runDate = new DateTime();

		$descriptorspec = [
			1 => ["pipe", "w"],  // stdout is a pipe that the child will write to
			2 => ["pipe", "w"],  // stdout is a pipe that the child will write to
		];

		$process = proc_open($request->getCommand(), $descriptorspec, $pipes, $request->getCwd());

		if (!is_resource($process)) {
			throw new ExecuteCommandException('Execute error!');
		}

		$out = trim(stream_get_contents($pipes[1]));
		fclose($pipes[1]);

		$error = trim(stream_get_contents($pipes[2]));
		fclose($pipes[2]);

		$exitCode = proc_close($process);
		$valid = $exitCode === 0;

		return new Response([
			'out' => $out,
			'error' => $error,
			'valid' => $valid,
			'exitCode' => $exitCode,
			'command' => $request->getCommand(),
			'runDate' => $this->runDate,
			'cwd' => $request->getCwd(),
		]);
	}
}