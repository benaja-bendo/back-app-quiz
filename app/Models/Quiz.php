<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[
    OA\Schema(
        title: "Quiz",
        description: "Quiz model",
        required: ["last_name", "first_name", "email", "password"],
        properties: [
            new OA\Property(property: "last_name", description: "Last name of the user", type: "string"),
            new OA\Property(property: "first_name", description: "First name of the user", type: "string"),
            new OA\Property(property: "middle_names", description: "Middle names of the user", type: "string"),
            new OA\Property(property: "avatar", description: "Avatar of the user", type: "string"),
            new OA\Property(property: "gender", description: "Gender of the user", type: "string"),
            new OA\Property(property: "email", description: "Email of the user", type: "string"),
            new OA\Property(property: "password", description: "Password of the user", type: "string"),
            new OA\Property(property: "birth_date", description: "Birth date of the user", type: "string"),
        ],
        type: "object",
        example: [
            "last_name" => "Doe",
            "first_name" => "John",
            "middle_names" => "Smith",
            "avatar" => "https://example.com/avatar.jpg",
            "gender" => "Male",
            "email" => "exampel@mail.com",
            "password" => "password",
            "birth_date" => "1990-01-01",
            "addresses" => [],
            "number_phones" => [],
            "email_verified_at" => "2021-01-01",
            "created_at" => "2021-01-01",
            "updated_at" => "2021-01-01",
            "role" => []
        ],

    )
]

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'minutes',
        'level',
    ];

    public function questions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Question::class);
    }
}
