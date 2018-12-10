<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $userClass = app(config('wallet.user_model', 'App\User'));

        Schema::create('wallet_transactions', function (Blueprint $table) use ($userClass) {
            $table->increments('id');
            $table->unsignedInteger('wallet_id');
            $table->unsignedInteger($userClass->getForeignKey())->nullable();

            $table->integer('amount'); // amount is an integer, it could be "dollars" or "cents"
            $table->string('transaction_id', 60); // hash is a unique_id for each transaction
            $table->string('transaction_type', 30); // type can be anything in your app, by default we use "deposit" and "withdraw"

            $table->string('status'); // pending, success, failed
            $table->text('meta')->nullable(); // Add all kind of meta information you need

            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
}
