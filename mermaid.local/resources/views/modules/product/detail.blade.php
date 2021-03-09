
<div class="modal-header border-bottom">
    <h5 class="">{{ $product->name }}</h5>
    <div class="">
        <?php if ($model->state == 'PENDING'): ?>
        <button type="button" id="btn__approve" class="btn btn-sm btn-success pr-3" onclick="updateState({{ $model->id }}, 'PUBLIC', {{ $model->version }})">
            <i class="zmdi zmdi-check zmdi-hc-fw"></i> Duyệt
        </button>
        <button type="button" id="btn__reject" class="btn btn-sm btn-danger pr-3" onclick="updateState({{ $product->id }}, 'REJECT', {{ $model->version }})">
            <i class="zmdi zmdi-minus-circle-outline zmdi-hc-fw"></i> Từ chối
        </button>
        <?php endif; ?>
        <button type="button" class="btn btn-sm btn-secondary pr-3" data-dismiss="modal" aria-label="Đóng">
            <i class="zmdi zmdi-close zmdi-hc-fw"></i> Đóng
        </button>
    </div>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-4">
            <div class="product__img">
                @if($product->images)
                    <?php foreach ($product->images as $key => $value): ?>
                    <input type="hidden" data-src="{{$value}}"  data-id="{{$key}}">
                    <?php endforeach; ?>
                    <div class="fotorama" data-width="500" data-nav="thumbs" data-arrows="true">
                        @foreach($product->images as $key => $value)
                            <img src="{{ $value }}" data-id="{{$key}}">
                        @endforeach
                    </div>
                @else
                    <img src="{{ asset('assets/img/demo/img/group_empty.jpg') }}" alt="">
                @endif
            </div>

        </div>
        <div class="col-md-8">
            <div class="product__info flex-grow-1">
                <ul class="icon-list w-100">
                    <li>
                        <h4>Mô tả sản phẩm</h4>
                        <?php if ( $product->attributes): ?>
                        <?php foreach ($product->attributes as $key => $attribute): ?>
                        <div class="attribute-item d-flex mb-3 pb-2">
                            <div class="name pr-2 w-50">
                                <strong>{{ $attribute->name }}</strong>
                            </div>
                            <div class="value pl-2 w-50">
                                <span>{{$attribute->value->name }}</span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                         <?php endif; ?>
                        <div>
                            <strong>Description</strong>
                        </div>
                        <div>
                            {!!  $product->description  !!}
                        </div>
                    </li>
                    <li>
                        @if($product->variants )
                            <h4>Số lượng</h4>
                            <div class="table-responsive align-middle">
                                <table class="table table-hover table-bordered">
                                    <thead class="thead-light">
                                    <tr>
                                        <?php foreach ($classifies as $key => $value): ?>
                                        <th>{{ $value->name }}</th>
                                        <?php endforeach; ?>
                                        <th>Giá theo số lượng</th>
                                        <th>Số lượng</th>
                                        <th>Kho</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($variant2first as $k => $variantList): ?>
                                    <?php $c = 0; ?>
                                    <?php foreach ($variantList as $variant): ?>
                                    <?php
                                    $variant2Key = [];
                                    if ($variant->attributes) {
                                        $attributes = $variant->attributes;
                                        foreach ($attributes as $a) {
                                            $variant2Key[$a->name] = $a->value;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <?php foreach ($classifies as $key => $value): ?>
                                        <?php if ($c == 0 && $key == 0): ?>
                                        <td rowspan="{{ count($variantList) }}">{{ (isset($variant2Key[$value->name])) ? $variant2Key[$value->name] : '' }}</td>
                                        <?php else: ?>
                                        <?php if ($key > 0): ?>
                                        <td>{{ (isset($variant2Key[$value->name])) ? $variant2Key[$value->name] : '' }}</td>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <td>{{ (implode(" / ",$variantPrice)) }}</td>
                                        <td>{{ implode(" / ",$variantNumber)}}</td>
                                        <td>{{$variant->inventory}}</td>
                                    </tr>
                                    <?php $c++; ?>
                                    <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <?php if (!$classifies): ?>
                                    <tr>
                                        <td>{{ (implode(" / ",$variantPrice)) }}</td>
                                        <td>{{ implode(" / ",$variantNumber)}}</td>
                                        <td>{{$inventory}}</td>
                                    </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/bower_components/fotorama-4.6.4/fotorama.js') }}"></script>
