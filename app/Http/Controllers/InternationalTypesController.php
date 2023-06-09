<?php

namespace App\Http\Controllers;

use App\Models\InternationalTypes;
use Illuminate\Http\Request;

class InternationalTypesController extends Controller
{
    public function index()
    {
        $pageTitle = 'التصنيفات  ';
        $types = InternationalTypes::orderBy("id", 'DESC')->get();
        $formUrl = adminUrl('international-publishing/types/store');
        $btnText = 'إضافة';
        $id = isset($_GET['id']) ? intval($_GET['id']) : NULL;
        $row = NULL;
        if ($id != NULL) {
            $row = InternationalTypes::find($id);
            if (empty($row)) {
                return redirect(adminPrefix() . '/international-publishing/types-of-publication');
            } else {
                $formUrl = adminUrl('international-publishing/types/update');
                $btnText = 'تحديث';
            }
        }
        return view("admin.international-types.index", compact('pageTitle', 'types', 'row', 'formUrl', 'btnText'));
    }
    public function store(Request $request)
    {
        $request->validate(['type' => 'required|max:255',]);
        $insert = InternationalTypes::create(['type' => $request->type,]);
        if ($insert->save()) {
            $request->session()->flash("success", 'تم إضافة البيانات بنجاح');
            return back();
        }
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $row = InternationalTypes::find($id);
        if (!empty($row)) {
            $request->validate(['type' => 'required|max:255',]);
            $row->type = $request->type;
            if ($row->save()) {
                $request->session()->flash('success', 'تم تحديث البيانات بنجاح');
                return back();
            }
        } else {
            $request->session()->flash('error', 'هذه البيانات ليست متاحة في النظام');
            return back();
        }
    }
    public function destroy(Request $request)
    {
        $row = InternationalTypes::find($request->id);
        if (!empty($row)) {
            $row->delete();
            $request->session()->flash('success', 'تم حذف البيانات بنجاح');
            return back();
        }
        return back();
    }
}
