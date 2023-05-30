<?php

    namespace App\Http\Requests;

    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Helpers\Status;
    use Illuminate\Contracts\Validation\Validator;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Http\Exceptions\HttpResponseException;
    use Illuminate\Validation\ValidationException;

    class StoreMessageRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return true;
        }

        public function rules()
        {
            return [
                'to_account_id' => 'required|string|exists:accounts,id',
                'content' => 'required|string',
            ];
        }

        protected function failedValidation(Validator $validator)
        {
            $validator_errors = (new ValidationException($validator))->errors();
            throw new HttpResponseException(ResponseHelper::send([], Status::NOT_GOOD, HttpCode::BAD_REQUEST,
                reset($validator_errors)[0]));
        }
    }
