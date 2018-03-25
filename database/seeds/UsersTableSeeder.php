<?php

use Illuminate\Database\Seeder;
use App\Models\Dormitory;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);

        $dorms = Dormitory::all()->where('type', 'dormitory')->pluck('id')->toArray();

        // 头像假数据
        $avatars = [
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];

        $users = factory(User::class)->times(10)->make()
                ->each(function ($user, $index) use ($faker, $dorms, $avatars){
                    $user->avatar = $faker->randomElement($avatars);
                    $user->dormitory_id = $faker->randomElement($dorms);
                });
        $user_array = $users -> makeVisible(['password','remember_token'])->toArray();

        User::insert($user_array);

        $user = User::find(1);
        $user -> student_id = 10001;
        $user -> email = 'admin@admin.com';
        $user -> nickname = 'admin';
        $user -> payment_password = md5(1234);
        $user -> dormitory_id = 3;
        $user -> is_verify = true;
        $user -> save();
    }
}
