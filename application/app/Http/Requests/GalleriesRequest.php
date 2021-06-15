<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GalleriesRequest
 *
 * @package App\Http\Requests
 *
 * @property string $img
 * @property array $tags
 * @property string $description
 */
class GalleriesRequest extends FormRequest
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
            'img' => 'string|min:3',
            'tags' => 'nullable|array',
            'description' => 'string|min:3',
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
