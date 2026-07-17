<?php

namespace App\Http\Requests\Lobby;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateLobbyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lobbyCode' => ['required', 'string', 'regex:/^.{7}$/']
        ];
    }

    public function getLobbyCode(): string
    {
        return $this->input('lobbyCode');
    }
}
