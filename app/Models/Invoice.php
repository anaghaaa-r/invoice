<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity', 
        'amount', 
        'total_amount', 
        'tax_percentage', 
        'tax_amount', 
        'net_amount', 
        'name',
        'invoice_date', 
        'file', 
        'email'];
}
