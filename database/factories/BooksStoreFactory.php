<?php

	namespace Database\Factories;

	use App\Models\Store;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\Factory;

	class BooksStoreFactory extends Factory
	{
		public function definition ()
		{
			return [
                'name' => $this->faker->name,
                'author' => $this->faker->name,
                'isbn' => $this->faker->isbn13(''),
                'value' => $this->faker->randomFloat(2, 0, 1000),
                'user_id' => User::factory()->create()->id,
                'store_id' => Store::factory()->state([
                    'name' => $this->faker->name,
                ])->create()->id,
            ];
		}
	}
