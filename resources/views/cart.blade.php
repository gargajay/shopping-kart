<table class="table table-image">
          <thead>
            <tr>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Qty</th>
              <th scope="col">Total</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
           
              @forelse($cart as $item)
              <tr>
              <td>{{$item->product->name}}</td>
              <td>$ {{$item->product->price}}</td>
              <td class="qty"><input type="number" oninput="updateItem('{{$item->id}}',this.value)"  min="0" data-item-id="{{$item->id}}"class="form-control qtyInput" id="input1" value="{{$item->qty}}"></td>
              <td>$ {{$item->product->price * $item->qty}}</td>
              <td>
                <a href="#" onclick="removeItem({{$item->id}})" class="btn btn-danger btn-sm">
                  Delete
                </a>
              </td>
              </tr>
              @empty
            <tr>
              <td colspan="5">No Item in cart!</td>
            </tr>

              @endforelse
              
          </tbody>
        </table> 
        <div class="d-flex justify-content-end">
          <h5>Total: <span class="price text-success">$ {{$total}}</span></h5>
        </div>