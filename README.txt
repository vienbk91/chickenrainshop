//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// CakePHP3.3.1 Kiến thức cơ bản và cách xây dựng chickenrainshop project
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Phần 1: Các thiết lập ban đầu
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
1. Phân tích yêu cầu: 
Chickenrainshop là dự án triển khai hệ thống bán sách online được xây dựng bằng CakePHP3.3
Nó bao gồm 3 phần chính: 
 + Home: Trang chủ, hiển thị danh sách các cuốn sách có trong kho (bổ sung chức 
năng tìm kiếm sách,...)
 + Thông tin sách: hiển thị nội dung cụ thể từng cuốn sách
 + Thông tin giỏ hàng: Hiển thị thông tin giỏ hàng của khách khi đặt mua sách 
Ngoài ra chức năng admin sẽ được sử dụng để quản lý sách.

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
2. Xây dựng mô hình dữ liệu và csdl cho project 

CDM: Conceptual Data Model (Mô hình dữ liệu quan niệm hay mô hình quan niệm thực thể): 
là mô hình chi tiết mô tả toàn bộ cấu trúc dữ liệu tổ chức mà nó không phụ thuộc vào 
bất kỳ một hệ quản trị cơ sở dữ liệu nào hay sự xem xét việc cài đặt. Đây là một mô 
hình biểu diễn mức độ hợp lý, chi tiết về dữ liệu của một tổ chức hay một hệ thống.
CDM biểu diễn các thực thể chứa các thuộc tính và các thực thể này có quan hệ với nhau, 
có thể là 1-nhiều, nhiều-nhiều, hay là nhiều-1.

PDM: Physical Data Model (Mô hình dữ liệu vật lý) mô hình này thể hiện sự sắp xếp và cài 
đặt của dữ liệu trên một hệ quản trị cơ sở dữ liệu nào đó (trong video thì PDM thể hiện 
sự cài đặt của dữ liệu trên mySQL).
PDM biểu diễn các table (bảng) có mối quan hệ với nhau, mỗi bảng có nhiều trường dữ liệu 
trong đó.

Các quy tắc của CakePHP khi tạo CSDL:

- Tên bảng đặt theo dạng số nhiều của tiếng anh (thêm s, hoặc es)
VD: teams, books, matches...
Và không dùng các từ dễ bị nhầm lẫn với từ khóa của CakePHP(file, new...)
- Khóa chính (primary key) được quy định tên mặc định là id, thuộc kiểu int và là trường 
số tự tăng (auto_increment)
- Khóa ngoại (foreign key) được quy định là tên bảng ở dạng số ít và kèm với cụm _id.
VD: category_id, book_id...

- Các trường created và modified: thuộc kiểu dateime hoặc timestamp mặc định là null. 
Và 2 trường này dùng để lưu ngày tạo mẩu tin (created), và ngày bạn update mẩu tin đó 
(updated) một cách tự động, và chúng ta không cần phải thao tác gì trên đó cả.


/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
3. Xây dựng Model - View - Controller từ csdl đã có

1.1. Cài đặt componer với Xampp
Bây giờ ta sẽ vào trang chủ của Composer-> Getting Started -> Locally -> Click vào link: the Dowload Page và nó sẽ đưa ta đến đường dẫn sau:
https://getcomposer.org/download/ 
Tại đây bạn sẽ thấy có 2 cách cài đặt và sử dụng file exe để cài trực tiếp hoặc dùng commandline để cài bằng dòng lệnh. Tôi sử dụng commandline
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

Bây giờ ta chỉ việc bật chế độ Shell của Xampp, di chuyển tới thư mục htdocs 
(chương trình Shell mặc định root tại thư mục cài đặt xampp nên ta cần di chuyển tới thư mục htdocs ở bên trong nó )
>cd htdocs
Parse đoạn mã trên vào, nó sẽ thực thi từng dòng lệnh 1 như sau

> php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
> php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
> php composer-setup.php
> php -r "unlink('composer-setup.php');"

Và đây là kết quả thực thi
 
Bây giờ bên trong thư mục htdocs sẽ xuất hiện 1 file đó là Conposer.phar , đây chính là file thực thi của conposer
 
1.2. Tạo project chickenrainshop
Tiếp theo ta sẽ sử dụng composer để tạo 1 project tên là bookmarker. Vẫn tiếp tục bằng chương trình Shell Command của Xampp, ta thực thi lệnh sau:

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
php composer.phar create-project --prefer-dist cakephp/app chickenrainshop
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 
Sau khi đợi nó tự động install các package cần thiết thì nó sẽ hỏi bạn có muốn thiết lập quyền sở hữu (folder permissions) cho folder “app/config” hay không? Bạn hãy chọn y
Như vậy bây giờ trong thư mục htdocs đã tự động sinh ra 1 project có tên là “chickenrainshop” 

Ta import csdl đã được xây dựng vào database có tên: chickenrainshop

Bởi vì database được thiết kế theo những quy ước của CakePHP, 
cho nên ta có thể sử dụng chương trình “bake console” để sinh ra một cách nhanh chóng 
một chương trình đơn giản. Ta thực thi các lệnh sau:

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
# cd htdocs/bookmarker
# bin\cake bake all books
# bin\cake bake all categories
# bin\cake bake all comments
# bin\cake bake all coupons
# bin\cake bake all groups
# bin\cake bake all orders
# bin\cake bake all users
# bin\cake bake all writers
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

Sau khi thực thi tất cả các lệnh trên thì nó đã tự động sinh code ra cho chúng ta.
Ngoài ra trong phần này mình cũng nhắc qua về 1 số quy ước khi viết front-end và back-end
Ở đây mình định nghĩa 
front-end là phần xử lý view của người dùng, là phần hệ thống tương tác trực tiếp với người 
dùng như là hiển thị danh sách sách , search sách , hiển thị thông tin sách , hiển thị giỏ hàng, 
thao tác giỏ hàng và các xử lý tương tác
back-end là phần của admin dùng để xử lý việc thêm , sửa, xóa ,...đối với sách cũng như người dùng.
Như vậy để dễ dàng hơn khi làm việc, ta sẽ tuân thủ 1 số quy định sau đây: 
+ URL:
front-end: /controller/action -> URL: /books/index
back-end:  /admin/controller/action -> URL: admin/books/admin_index
+ Action - View
front-end: function index(){} -> view tương ứng: index.ctp
back-end:  function admin_index() {} => view tương ứng: admin_index.ctp
+ Layout
Trong cake thì khi sử dụng layout nó được mặc định sử dụng 1 layout là default.ctp
Như vậy ta cũng sẽ phân chia layout mặc định của front-end và back-end như sau:
front-end layout: Layout/default.ctp
back-end layout:  Layout/admin.ctp

Bây giờ ta sẽ tìm hiểu qua về file default.ctp và cấu trúc của nó.
File này là file layout mặc định được cake sử dụng khi load trang , nó là nơi định nghĩa các 
file css , js được sử dụng trong chương trình (Khi phát triển thì có thể tùy mục đích mà ta định nghĩa
lại cũng được)

Trong cakePHP2.x thì nó được viết 
<?php
    echo $this->Html->meta('icon');

    echo $this->Html->css('cake.generic');
    echo $this->Html->css('mystyle');
    
    echo $this->Html->script('jquery-3.1.0.min');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
?>

Ở đây nó sử dụng Helper Html do cake xây dựng sẵn để load file css,js theo tên của chúng.
Các file này sẽ được đặt trong thư mục webroot/css và webroot/js

Tuy nhiên chuyển sang CakePHP3.x thì nó có cách viết khá lạ
<?= $this->Html->css('mystyle') ?>
Vậy cách này thì có gì khác cách trên ? Thực ra là không khác gì nhau cả, cách viết này
là một dạng short_open_tag (bạn có thể đọc về echo trong php để tìm hiểu về cách viết này)

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
Phần 2: Quản lý nội dung
4. Các phương pháp truy vấn dữ liệu trong CakePHP

Trong CakePHP , thông thường sử dụng 2 hàm là find() và query() để truy vấn dữ liệu
Ta sẽ đi nói về từng hàm, chức năng và cách dùng của nó
1 - find($type , $option)
Đối với $type - kiểu truy vấn:
+all : tìm và lấy hết các mẫu tin trong csdl
+fist: tìm và trả về mẫu tin đầu tiên tìm thấy trong csdl
+list: tương tự như all nhưng chỉ trả về id
+count:tìm những dữ liệu đc yêu cầu và trả về số mẫu tin mà nó tìm được
+neighbors: Trả về mẫu tin đứng trước và sau mẫu tin mà chúng ta yêu cầu nó tìm
+threaded: Thường sử dụng cho dữ liệu có cấu trúc cây, 
chẳng hạn như khi ta sử dụng TreeBehavior vào tìm categories thì ta cần dùng sử 
dụng kiểu truy vấn này để làm cây danh mục.

Đối với option - các tùy chọn khi truy vấn và được đặt trong 1 mảng , có 1 số tùy chọn 
mà ta hay sử dụng
+fields: Tùy chọn này sẽ giúp chúng ta lấy các trường dữ liệu mà chúng ta muốn trong csdl
+conditions: Điều kiện khi tìm kiếm csdl
+order: sắp xếp csdl theo 1 trường nào đó theo 1 thứ tự nào đó
+limit: Lấy ra số lượng mẫu tin chỉ định (chỉ định là interger)
+recursive: Tùy chọn này sẽ lấy dữ liệu theo mối quan hệ của bảng dữ liệu mà ta cần lấy
Và có 4 mức recursive cho chúng ta tùy chọn là : -1 , 0 , 1 và 2

VD: //Cakephp2.x
$notes = $this->Model->find('all' , array(
    'fields' => array('id' , 'title' , 'content') ,
    'conditions' => array('title LIKE' => '%PHP%') ,
    'order' => array('id' => 'asc') , // array('id asc'); cũng được
    'limit' => 5
));

Trong cakephp2.x thì việc sử dụng find($type , $option) sẽ không có vấn đề gì xảy ra nhưng
từ cakephp3.x trở đi, nó đã được thay thế khá nhiều.
Trong cakephp3.x document, nó viết về việc sử dụng hàm find, nhưng thông qua 1 instance của Model
nên trước khi sử dụng hàm find() này, ta cần load nó bằng cách:
$instance_tbl = TableRegistry::get('tbl_name');
$result = $instance_tbl->find($type , $option);
Trong cakephp3.x thì những $type = 'first' , 'count' sẽ không còn sử dụng được nữa , mà thay vào đó
ta sẽ sử dụng $type = 'all' với $option , sau đó lấy kết quả thu được gọi tới first() , count()
VD:
$first = $result->first();
$count = $result->count();

Đối với find('neghbors') thì trong CakePHP3.x đã không còn hỗ trợ nó nữa, nên nếu muốn sử dụng bạn có thể
biến tấu nó theo cách sau:
src/Models/Table/ExampleTable.php
/**
 * Find an item from a table by slug, along with it's two adjacent items
 *
 * @param string $slug
 * @return array
 */
public function neighbours(Query $query , $slug) {
    $current = $this->find()
        ->where(['slug' => $slug])
        ->first();

    $previous = $this->find()
        ->where(['publish_date <' => $current->publish_date->format('Y-m-d')])
        ->order(['publish_date' => 'DESC'])
        ->first();

    $next = $this->find()
        ->where(['publish_date >' => $current->publish_date->format('Y-m-d')])
        ->order(['publish_date' => 'DESC'])
        ->first();

    return [
        'current' => $current,
        'previous' => $previous,
        'next' => $next
    ];
}
src/Controller/ExamplesController.php
public function view($id = null) {
    $neighbors = $this->Examples->find('neighbors', $id );
}



2- query() 
Đối với query() thì sẽ rất thuận tiện cho những ai chưa thực sự quen thuộc với hàm find()
Vì chỉ cần viết câu lệnh SQL và truyền vào query như 1 tham số thì nó sẽ thực thi tìm kiếm
như những gì câu lệnh sql yêu cầu.


