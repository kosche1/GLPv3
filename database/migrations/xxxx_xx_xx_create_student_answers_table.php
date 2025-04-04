public function up()
{
    Schema::create('student_answers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->foreignId('task_id')->constrained();
        $table->text('output')->nullable();
        $table->string('status')->default('submitted');
        $table->boolean('is_correct')->default(false);
        $table->integer('score')->default(0);
        $table->timestamps();
    });
}