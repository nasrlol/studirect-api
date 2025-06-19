<?php

namespace App\Services;

use App\Models\Appointment;

class AppointmentService
{
    public function appointmentTimeOverlap(array $data, $id = null): bool
    {
        $query = Appointment::where('company_id', $data['company_id'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('time_start', [$data['time_start'], $data['time_end']])
                    ->orWhereBetween('time_end', [$data['time_start'], $data['time_end']])
                    ->orWhere(function ($query_) use ($data) {
                        $query_->where('time_start', '<=', $data['time_start'])
                            ->where('time_end', '>=', $data['time_end']);
                    });
            });

        if ($id) {
            $query->where('id', '!=', $id);
        }
        return $query->exists();
    }
}
