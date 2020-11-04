<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\product;
use App\list_product;

class dashboard_controller extends Controller
{
    //
    public function index()
    {
        return view('index');
    }

    public function add_product()
    {
        return view('products.add_product');
    }

    public function form_add_product(Request $request)
    {
        $Add_product = new product();

        if ($Add_product) {

            $arr_1= explode(' ',trim($request->input('product_family')));
            if (count($arr_1)> 1) {
                $output_1 = $arr_1[0];
                $output_2 = $arr_1[1];
                $product_family = strtoupper($output_1[0]).strtoupper($output_2[0]);
            }else {
                $product_family = strtoupper($request->input('product_family')[0]).strtoupper($request->input('product_family')[1]);
            }

            $arr_2= explode(' ',trim($request->input('product_type')));
            if (count($arr_2)> 1) {
                $output_3 = $arr_2[0];
                $output_4 = $arr_2[1];
                $product_type = strtoupper($output_3[0]).strtoupper($output_4[0]);
            }else {
                $product_type = strtoupper($request->input('product_type')[0]).strtoupper($request->input('product_type')[1]);
            }

            $arr_3= explode(' ',trim($request->input('category')));
            if (count($arr_3)> 1) {
                $output_5 = $arr_3[0];
                $output_6 = $arr_3[1];
                $category = strtoupper($output_5[0]).strtoupper($output_6[0]);
            }else {
                $category = strtoupper($request->input('category')[0]).strtoupper($request->input('category')[1]);
            }

            $vn_product = product::where('category','LIKE','%'.$request->input('category')."%")
                                    ->Orwhere('product_type','LIKE','%'.$request->input('product_type')."%")
                                    ->get();
            $nb = count($vn_product);

            $le_referent =  $product_family.$product_type.$category.$nb.(strlen($request->input('product_type')));
            $Add_product->referent = $le_referent;

            $Add_product->title = $request->input('title');
            $Add_product->description = $request->input('description');
            $Add_product->category = $request->input('category');
            $Add_product->quantity = $request->input('quantity');
            $Add_product->price_min = $request->input('price_min');
            $Add_product->price_max = $request->input('price_max');
            $Add_product->alarm_stock = $request->input('alarm_stock');
            
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();// extension
                $filename = time().'.'.$extension;
                $file->move('uploads/product/', $filename);
                $Add_product->image = $filename;
            }else {
                return $request;
                $Add_product->image = '';
            }

            $img = $Add_product->image;
            $array = array();

            $Add_product->product_type = $request->input('product_type');
            $Add_product->provider = $request->input('provider');
            $Add_product->tax = $request->input('tax');
            $Add_product->price_achat = $request->input('price_achat');
            $Add_product->update = json_encode($array);

            $Add_product->save();

            if ($Add_product) {
                return redirect('/add_product')->with('success', 'product OK');
            } else {
                return redirect('/add_product')->with('error', 'product NON');
            }
            

        } else {
            return view('/dashboard')->with('status_err', $request);
        }
    }

    public function list_product()
    {
        $add_product = DB::table('product')
                            ->orderBy('category', 'ASC')
                            ->paginate(5);
        return view('products.list_product')->with('add_product',$add_product);
    }

    public function show_product($id)
    {
        $add_product = product::find($id);
        return view('products.show_product')->with('add_product',$add_product);
    }

    public function search()
    {
        return view('products.search_product');
    }

    public function edit_product($id)
    {
        $add_product = product::find($id);
        return view('products.edit_product')->with('add_product',$add_product);
    }

    public function form_edit_product(Request $request, $id)
    {
        $add_product = product::find($id);

        if ($add_product) {

            $add_product->referent = $request->input('referent');
            $add_product->title = $request->input('title');
            $add_product->description = $request->input('description');
            $add_product->category = $request->input('category');
            $add_product->quantity = $request->input('quantity');
            $add_product->price_min = $request->input('price_min');
            $add_product->price_max = $request->input('price_max');
            $add_product->alarm_stock = $request->input('alarm_stock');
            
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();// extension
                $filename = time().'.'.$extension;
                $file->move('uploads/product/', $filename);
                $add_product->image = $filename;
            }else {
                return $request;
                $add_product->image = $filename;
            }

            $img = $add_product->image;
            $array = array();

            $prix_min_last = $request->input('prix_min_last');
            $prix_max_last = $request->input('prix_max_last');
            $prix_achat_last = $request->input('prix_achat_last');
            $last_update = $request->input('last_update');
            $quantity_last = $request->input('quantity_last');

            $update = json_decode(($request->input('update')), true);
            array_push($array, $update, $prix_achat_last,$prix_max_last, $prix_min_last);

            $add_product->product_type = $request->input('product_type');
            $add_product->provider = $request->input('provider');
            $add_product->tax = $request->input('tax');
            $add_product->price_achat = $request->input('price_achat');
            $add_product->update = json_encode($array);

            $add_product->update();

            if ($add_product) {
                return redirect('/list_product')->with('add_product', 'add_product produit Modifier');
            }

        } else {
            return view('/agence_A')->with('status_err', $request);
        }
    }


    //////////////////////////////////////

    public function search_product(Request $request)
    {
      
       if($request->ajax()){
    
         $output="";
         $i=0;
         
         $search = product::where('title','LIKE','%'.$request->search."%")
                                    ->Orwhere('referent','LIKE','%'.$request->search."%")
                                    ->Orwhere('category','LIKE','%'.$request->search."%")
                                    ->get();
         
         if($search){
      
            foreach ($search as  $item) {
            
                $output.='<tr>'.
             
             '<td>'.'<span class="col-green">'.$item->id.'</span>'.'</td>'.
             
             '<td>'.
                '<a href="/show_product/'.$item->id.'">'.'<img style="max-width:100" width="80" src="uploads/product/'.$item->image.'">'.
             '</td>'.

             '<td>'.$item->referent.'</td>'.
             
             '<td>'.'<span class="text-muted">'.$item->title.'</span>'.'</td>'.

             '<td>'.'<span class="text-color">'.$item->description.'</span>'.'</td>'.

             '<td>'.'<span class="text-color">'.$item->category.'</span>'.'</td>'.

             '<td>'.'<span class="text-muted">'.$item->quantity.'</span>'.'</td>'.

             '<td class="price_min">'.'<span class="col-green">'.$item->price_min.'</span>'.'</td>'.

             '<td class="price_max">'.'<span class="col-red">'.$item->price_max.'</span>'.'</td>'.

             '<td>'.'<span class="text-muted">'.$item->alarm_stock.'</span>'.'</td>'.
             
             '<td>'.'<span class="text-muted">'.$item->product_type.'</span>'.'</td>'.

             '<td>'.'<span class="text-muted">'.$item->provider.'</span>'.'</td>'.

             '<td>'.'<span class="text-muted">'.$item->tax.'</span>'.'</td>'.
             
             
             '<td>'.
            '<a href="/edit_product/'.$item->id.'" class="btn btn-primary waves-effect waves-float waves-green"><i class="fa fa-edit"></i></a>'.
            '</td>'.
            '<td>'.
            '<form action="/delete_product/'.$item->id.'" method="GET">'.
                csrf_field().
                method_field("DELETE").
                '<button type="submit" onclick="if(confirm("Are you sure ? Vous ne pourez rien modifier") == true){ return true; } else {return false}" class="btn btn-danger waves-effect waves-float waves-red">'.
                    '<i class="fa fa-trash"></i>'.
                '</button>'.
            '</form>'.
            '</td>'.
             
             '</tr>';
         
            }
            return $output;  
 
         }else {
            $output.='<div class="col-md-12">
							<div class="card full-height ">
								<div class="card-body">
                                    <div class="alert alert-danger" role="alert">
                                        <b>AUCUN product AVEC CES IDENTIFIANTS</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                ';
                
            return $output;  
         }
   
       }
 
    }

    public function dashboard()
    {
        return view('agence_A.dashboard');
    }

    public function form_add_family(Request $request)
    {

        $famille = list_product::find(1);
        if ($famille) {
            $array = array();
            $all_fam = json_decode(($famille->all_familly), true);
            $count = count($all_fam);
            for ($i=0; $i < $count; $i++) { 
                array_push($array, $all_fam[$i]);
            }

            array_push($array, $request->input('add_family'));

            $array = json_encode($array);
            
            $famille->all_familly = $array;
            $famille->save();
            if ($famille) {
                return redirect('/dashboard')->with('add_family', 'LA FAMILLE A ETE AJOUTEE AVEC SUCCESS');
            } else {
                return redirect('/dashboard')->with('error', 'L erreurs est survenu!!!');
            }
        } else {
            return redirect('/dashboard')->with('error', "Nous avons rencontre un probleme lors de l'execution");
        }
        
    }
    public function form_add_type(Request $request)
    {

        $type = list_product::find(1);
        if ($type) {
            $array = array();
            $all_type = json_decode(($type->all_type), true);
            $count = count($all_type);
            for ($i=0; $i < $count; $i++) { 
                array_push($array, $all_type[$i]);
            }

            array_push($array, $request->input('add_type'));

            $array = json_encode($array);
            
            $type->all_type = $array;
            $type->save();
            if ($type) {
                return redirect('/dashboard')->with('add_family', 'LE TYPE A ETE AJOUTEE AVEC SUCCESS');
            } else {
                return redirect('/dashboard')->with('error', 'L erreurs est survenu!!!');
            }
        } else {
            return redirect('/dashboard')->with('error', "Nous avons rencontre un probleme lors de l'execution");
        }
        
    }
    public function form_add_categorie(Request $request)
    {

        $categorie = list_product::find(1);
        if ($categorie) {
            $array = array();
            $all_categorie = json_decode(($categorie->all_categorie), true);
            $count = count($all_categorie);
            for ($i=0; $i < $count; $i++) { 
                array_push($array, $all_categorie[$i]);
            }

            array_push($array, $request->input('add_categorie'));

            $array = json_encode($array);
            
            $categorie->all_categorie = $array;
            $categorie->save();
            if ($categorie) {
                return redirect('/dashboard')->with('add_family', 'LA CATEGORIE A ETE AJOUTEE AVEC SUCCESS');
            } else {
                return redirect('/dashboard')->with('error', 'L erreurs est survenu!!!');
            }
        } else {
            return redirect('/dashboard')->with('error', "Nous avons rencontre un probleme lors de l'execution");
        }
        
    }

}
