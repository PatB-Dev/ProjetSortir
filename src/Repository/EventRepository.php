<?php

namespace App\Repository;

use App\Entity\Event;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;



/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getAll(){
        $date = new \DateTime();
        $req = $this->createQueryBuilder('event')
            ->where('event.registrationLimit> :date')->setParameter('date', $date)
            ->orderBy('event.registrationLimit', 'ASC');

        return $req->getQuery()->getResult();
    }

    public function updateBDD(){
        $date = new \DateTime('NOW', new \DateTimeZone('EUROPE/Paris'));
        //Moins 1 jour sur la date du jour
        $date->modify("-1 day");

        //Recup des sorties avec une date limite d'inscription supérieur à la date du jour
        //Passage en status 3-Closed
        $req = $this->createQueryBuilder('event')
            ->update(Event::class, 'event')->set('event.status', '?1')
            ->where('event.registrationLimit< :date')
            ->setParameter(1, '3')
            ->setParameter('date', $date);
        $req->getQuery()->execute();
    }

    //Les filtres sur les événement
    public function filterEvent($keyWord, $campus, $dateStart, $dateEnd){

                //                $eventOrganizer, $eventSuscriber, $eventNotSuscriber, $eventOld

        // recuperer les méthodes du querybuilder (alias de l'entité)
        $qb = $this->createQueryBuilder('event');

        if(!empty($keyWord)){
            $qb ->andWhere('event.eventName LIKE :eventName')
                ->setParameter('eventName', '%'.$keyWord.'%')
            ;}

        if(!empty($campus)){
            $qb ->andWhere('event.campus = :campus')
                ->setParameter('campus', $campus)
            ;}

        // dateStart
        if(!empty($dateEnd) || !empty($dateStart)){
            $qb ->andWhere('event.dateAndHour = :dateAndHour')
                ->setParameter('dateAndHour', $dateStart)
            ;}

        // dateEnd
        if(!empty($dateEnd) || !empty($dateStart)){
            $qb ->andWhere('event.dateAndHour = :dateAndHour')
                ->setParameter('dateAndHour', $dateEnd)
            ;}

//        // eventOrganizer
//        if($eventOrganizer == true){
//            $qb ->andWhere('event = :')
//                ->setParameter('dateAndHour', $dateEnd)
//            ;}

        return $qb->getQuery()->getResult();
        }

    }