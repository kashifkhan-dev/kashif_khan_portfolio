<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTestimonialRequest;
use App\Http\Requests\Admin\UpdateTestimonialRequest;
use App\Models\Testimonial;
use App\Services\TestimonialService;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialController extends Controller
{
    public function __construct(
        protected TestimonialService $testimonialService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Testimonials/Index', [
            'testimonials' => $this->testimonialService->getAllTestimonials(),
        ]);
    }

    public function store(StoreTestimonialRequest $request)
    {
        $this->testimonialService->createTestimonial($request->validated());

        return redirect()->back()->with('success', 'Testimonial added successfully.');
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $this->testimonialService->updateTestimonial($testimonial, $request->validated());

        return redirect()->back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->testimonialService->deleteTestimonial($testimonial);

        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }

    public function toggleActive(Testimonial $testimonial)
    {
        $this->testimonialService->toggleActive($testimonial);

        return redirect()->back()->with('success', 'Testimonial status updated.');
    }
}
