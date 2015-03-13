<?php

namespace Vhrb\Executor\Command;

interface IExecutor
{
	/**
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function run(Request $request);
}