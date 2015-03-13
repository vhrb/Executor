<?php

namespace Vhrb\Executor;

interface IExecutor
{
	/**
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function run(Request $request);
}