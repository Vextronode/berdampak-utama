<x-app-layout :title="$project->title . ' - Detail Proyek | Berdampak Utama'">
    <div class="bg-surface-variant/40 min-h-screen py-8 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-8">
            <x-project.breadcrumb :title="$project->title" />

            <x-project.header :project="$project" />

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-8 flex flex-col gap-8">
                    <x-project.showcase :project="$project" />

                    <x-project.team-showcase :contributors="$project->contributors" />

                    <x-project.problem :problem="$project->problem_statement" :partner="$project->partner_name" />

                    <x-project.features :features="$project->features" />

                    <x-project.gallery :images="$project->gallery_images" :partner="$project->partner_name" />
                </div>

                <aside class="lg:col-span-4 flex flex-col gap-6 lg:sticky lg:top-24">
                    <x-project.sidebar-supervisor :project="$project" />

                    <div id="team-sidebar-dock" 
                         class="transition-all duration-300 ease-out overflow-hidden max-h-0 opacity-0 -translate-y-2 pointer-events-none hidden"
                         aria-hidden="true">
                        <x-project.sidebar-contributors :contributors="$project->contributors" />
                    </div>

                    <x-project.sidebar-tech-stack :tech-stack-items="$project->techStackItems" :tech-stacks="$project->tech_stacks" />

                    <x-project.sidebar-metadata :project="$project" />
                </aside>
            </div>

            <x-project.related :related-projects="$relatedProjects" />
        </div>
    </div>
</x-app-layout>
