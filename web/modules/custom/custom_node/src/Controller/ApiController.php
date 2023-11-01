<?php

namespace Drupal\custom_node\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;

class ApiController extends ControllerBase
{



    public function getNodeData()
    {

        $node_storage = \Drupal::entityTypeManager()->getStorage('node');
        $query = $node_storage->getQuery()
            ->condition('type', 'form');

        $nids = $query->execute();
        $nodes = $node_storage->loadMultiple($nids);

        $node_data = [];
        // dd($nodes);
        foreach ($nodes as $node) {

            $node_data[] = [
                'nid' => $node->id(),
                'title' => $node->get('field_name')->value,
                'desc' => $node->get('body')->value
            ];
        }
        return new JsonResponse($node_data);
    }

    public function postNodeData(Request $request){
        $content = json_decode($request->getContent(),TRUE);
        $node = Node::create([
            'type' => 'form',
            'title' => $content['title'],
            'field_name' => $content['desc']
        ]);
        $node->save();  
        // $node->setPublished();
        $message = [
            'message' => 'node created',
            'node_id' => $node-> id()
        ];

        return new JsonResponse($message);
    }
}
