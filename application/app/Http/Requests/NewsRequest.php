<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NewsRequest
 *
 * @package App\Http\Requests
 *
 * @property string $to
 * @property string $from
 * @property string $header
 * @property string $main_image
 */
class NewsRequest extends FormRequest
{
    /**
     * Метод проверяет можно ли пользователю отправлять эту форму или нет
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Метод возвращает правила валидации формы
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'slug' => 'nullable|string|min:3',
            'header' => 'string|min:3',
            'content' => 'string|min:3',
            'main_image' => 'string|min:3',
        ];
    }

    /**
     * Метод возвращает сообщение при не верно введенных данных
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            '*' => 'The :attribute field is wrong.',
        ];
    }
}
