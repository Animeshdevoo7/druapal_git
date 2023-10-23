<?php
    namespace Drupal\employee\Controller;
    use Drupal\Core\Controller\ControllerBase;
    use Drupal\Code\Database\Database;

    class EmployeeController extends ControllerBase{
        public function createEmployee(){
            $form = \Drupal::formBuilder()-> getForm('Drupal\employee\Form\EmployeeForm');
            #$renderForm = \Drupal::service('renderer')->render($form);
            
            return [
                '#theme'=>'employee',
                '#items'=>$form,
                '#title'=>'Employee Form'
            ];
        }
        public function getemployeeList(){
            $limit=5;
            $query = \Drupal::database();
            $result=$query->select("employees","e")
                    ->fields('e',['id','name','gender','about_employee'])
                    ->extend ('Drupal\Core\Database\Query\PagerSelectExtender')->limit($limit)
                    ->execute()->fetchAll(\PDO::FETCH_OBJ);
                    
            $data=[];
            $count=0;
            $params = \Drupal::request()->query->all(); 
            if (empty($params)|| $params['page']==0){
                $count=1;
            }
            elseif($params['page']=1){
                $count=$params['page'] + $limit;
            }
            else{
                $count= $params['page'] * $limit;
                $count++; 
            }

            foreach($result as $row){
                $data[]=[
                    'serial'=>$count,
                    'name'=>$row->name,
                    'gender'=>$row->gender,
                    'about_employee'=>$row->about_employee,
                    'edit'=> t("<a href='edit-employee/$row->id'>Edit</a>"),
                    'delete'=> t("<a href='delete-employee/$row->id'>Delete</a>")
                ];
                $count++;
            }
            $header = array('S.no.','Name','Gender','About Employee','Edit','Delete');

            $build['table'] =[
                '#type'=> 'table',
                '#header'=> $header,
                '#rows'=>$data
            ];
            $build['pager']=[
                '#type'=> 'pager'
            ];
            return[
                $build,
                '#title'=> 'Employee List',
                '#cache'=> ['max-age' => 0]
            ];
        }
        public function deleteEmployee($id){
            $query = \Drupal::database();
            $query->delete('employees')
                  ->condition('id',$id,'=')
                  ->execute();

                  $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../employee-list');
                  $response->send();
                  $this->messenger()->addMessage($this->t('Record Deleted Successfully'), 'error',TRUE);  
        }
    }
