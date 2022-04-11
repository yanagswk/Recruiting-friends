<?php

namespace App\Library;

class Common
{
	/**
	 * バリデーション時レスポンス
	 */
	public static function makeValidationErrorResponse($error='')
	{
		return response()->json([
			'error' => $error
		], 422);
	}

	/**
	 * Not Foundレスポンス
	 */
	public static function makeNotFoundResponse(string $message=null)
	{
		return response()->json([
			'error' => $message
		], 404);
	}

	/**
	 * 正常時レスポンス
	 */
	public static function makeResponse(array $res)
	{
		return response()->json($res, 200);
	}

}