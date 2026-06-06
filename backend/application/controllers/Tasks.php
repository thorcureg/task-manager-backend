<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Base_model');
    }
    public function index(){
        $tasks = $this->Base_model->get_all_tasks('tasks');
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($tasks));
    }
    public function store(){
        $input = json_decode(file_get_contents('php://input'), true);
        if(empty($input['title'])){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'id'        => null,
                    'status'    => 'error',
                    'message'   => 'Title is required'
                ]));
            return;
        }
        
        $task = [
            'title' => $input['title'],
            'description' => $input['description'] ?? '',
            'is_completed' => $input['is_completed'] ?? 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $insert_id = $this->Base_model->insert_task('tasks', $task);
        if(!$insert_id){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'id'        => null,
                    'status'    => 'error',
                    'message'   => 'Failed to create task'
                ]));
            return;
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                    'id'        => $insert_id,  
                    'status'    => 'success',
                    'message'   => 'Task created successfully'
                ]));
    }
    public function update($id){
        $input = json_decode(file_get_contents('php://input'), true);
        if(empty($input['title']) && !isset($input['is_completed'])){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'id'        => null,
                    'status'    => 'error',
                    'message'   => 'Update either title or is_completed'
                ]));
            return;
        }
        $task = [
            'title' => $input['title'],
            'description' => $input['description'] ?? '',
            'is_completed' => $input['is_completed']
        ];
        $result = $this->Base_model->update_task('tasks', $id, $task);
        if(!$result){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'id'        => null,
                    'status'    => 'error',
                    'message'   => 'Failed to update task'
                ]));
            return;
        }
        return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'id' => $id,
            'status' => 'success',
            'message' => 'Task updated successfully'
        ]));
    }
    public function delete($id){
        $result = $this->Base_model->delete_task('tasks', $id);
        if(!$result){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'id'        => null,
                    'status'    => 'error',
                    'message'   => 'Failed to delete task'
                ]));
            return;
        }
        return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'id' => $id,
            'status' => 'success',
            'message' => 'Task deleted successfully'
        ]));
    }
}
?>