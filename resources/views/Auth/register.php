<?php
ob_start();
?>

<img src="./assets/bg.jpg" class="fixed top-0 left-0 right-0 bottom-0 -z-10" />
<div class="fixed top-0 left-0 right-0 bottom-0 -z-10 bg-black opacity-25"></div>
<img src="./assets/sakura-branch.png" class="w-1/4 fixed bottom-0 right-0 translate-x-[10%] translate-y-[20%]" />

<form method="POST" action="<?= route('register.create') ?>" class="text fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-[35%] text-white px-8 py-10 bg-black bg-opacity-25 backdrop-blur border rounded-lg flex flex-col">
    <img src="./assets/tori.png" style="width: 6rem;" class="absolute left-1/2 -translate-x-1/2 top-0 -translate-y-full" />
    <p class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 header welcome-bg py-2 px-4 rounded border text-xl whitespace-nowrap">Welcome!</p>
    <div class="flex items-center">
        <label for="name" class="rounded-full bg-white p-2 flex items-center justify-center z-10" style="width: 3rem; height: 3rem;">
            <img src="./assets/user.svg" class="opacity-75" />
        </label>
        <input id="name" name="name" type="name" value="<?= old("name") ?>" class="-translate-x-3 bg-[#969696] opacity-75 px-5 py-2 rounded-tr-full rounded-br-full placeholder:text-white placeholder:opacity-75" placeholder="Name" />
    </div>
    <?php if ($message = error('name')): ?>
        <p class="text-red-500 text-[12px]"><?= $message ?></p>
    <?php endif; ?>
    <div class="flex items-center mt-3">
        <label for="email" class="rounded-full bg-white p-2 flex items-center justify-center z-10" style="width: 3rem; height: 3rem;">
            <img src="./assets/envelope-solid.svg" class="w-3/4 opacity-50" />
        </label>
        <input id="email" name="email" type="email" value="<?= old("email") ?>" class="-translate-x-3 bg-[#969696] opacity-75 px-5 py-2 rounded-tr-full rounded-br-full placeholder:text-white placeholder:opacity-75" placeholder="Email" />
    </div>
    <?php if ($message = error('email')): ?>
        <p class="text-red-500 text-[12px]"><?= $message ?></p>
    <?php endif; ?>
    <div class="flex items-center mt-3">
        <input id="password" name="password" type="password" value="<?= old("password") ?>" class="bg-[#969696] opacity-75 px-5 py-2 rounded-tl-full rounded-bl-full placeholder:text-white placeholder:opacity-75" placeholder="Password" />
        <label for="password" class="rounded-full bg-white p-2 flex items-center justify-center z-10 -translate-x-3" style="width: 3rem; height: 3rem;">
            <img src="./assets/lock-solid.svg" class="w-3/5 opacity-50" />
        </label>
    </div>
    <?php if ($message = error('password')): ?>
        <p class="text-red-500 text-[12px]"><?= $message ?></p>
    <?php endif; ?>
    <div class="flex items-center mt-3">
        <input id="password_confirmation" name="password_confirmation" type="password" value="<?= old("password_confirmation") ?>" class="bg-[#969696] opacity-75 px-5 py-2 rounded-tl-full rounded-bl-full placeholder:text-white placeholder:opacity-75" placeholder="Confirm Password" />
        <label for="password_confirmation" class="rounded-full bg-white p-2 flex items-center justify-center z-10 -translate-x-3" style="width: 3rem; height: 3rem;">
            <img src="./assets/lock-solid.svg" class="w-3/5 opacity-50" />
        </label>
    </div>
    <p class="mt-8">
        <span class="opacity-75">Already have an account?</span>
        <a href="<?= route('login.view') ?>" class="underline">Login</a>
    </p>
    <button class="bg-[#EF3E3A] text-black py-2 rounded-full mt-3">Register</button>
</form>

<?php
$sections['content'] = ob_get_clean();
require basepath('resources/views/layout.php');
