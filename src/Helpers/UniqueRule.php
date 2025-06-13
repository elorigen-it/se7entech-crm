<?php
namespace Se7entech\Contractnew\Helpers;
use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['table', 'column', 'except'];

    protected $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');

        if ($except AND $except == $value) {
            return true;
        }

        // do query
        $sql = "select count(*) as count from `{$table}` where `{$column}` = '$value'";
        $res = mysqli_query($this->con, $sql);
        if(mysqli_num_rows($res)){
            $row = mysqli_fetch_assoc($res);
            return intval($row['count']) === 0;
        }
        
    }
}