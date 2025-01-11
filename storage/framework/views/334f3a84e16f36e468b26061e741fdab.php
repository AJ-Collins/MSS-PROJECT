

<?php $__env->startSection('reviewer-content'); ?>
<div class="min-h-screen bg-gray-50" x-data="assessmentForm">
    <!-- Main Content -->
    <div class="flex flex-col md:flex-row h-screen">
        <!-- Left Panel - Assessment Form -->
        <div class="w-full md:w-1/2 h-full flex flex-col border-r border-gray-200 bg-white">
            <!-- Header -->
            <div class="flex-none bg-white border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Document Assessment</h1>
                            <p class="mt-1 text-sm text-gray-500">Review and evaluate the abstract</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-sm text-gray-600">Total Score:</div>
                            <div class="px-3 py-1 bg-blue-50 rounded-lg">
                                <span x-text="totalScore" class="text-xl font-bold text-blue-600"></span>
                                <span class="text-blue-600">/50</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scrollable Form Content -->
            <div class="flex-1 overflow-y-auto">
                <form 
                    @submit.prevent="submitForm"
                    action="<?php echo e(route('reviewer.abstracts.assessment.store', $submission->serial_number)); ?>" 
                    method="POST" 
                    class="p-6 space-y-6"
                    id="assessmentForm">
                    <?php echo csrf_field(); ?>

                    <!-- Error Alert -->
                    <?php if($errors->any()): ?>
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Please check the following errors:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Success Message -->
                    <?php if(session('success')): ?>
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <!-- Assessment Sections -->
                    <template x-for="(section, key) in sections" :key="key">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            <span x-text="section.label"></span>
                                            <span class="text-red-500" x-text="` (Out of ${section.maxScore})`"></span>
                                        </label>
                                        <textarea 
                                            :name="`${key}_comments`"
                                            :placeholder="`Provide comments on the ${section.label.toLowerCase()}...`"
                                            class="mt-4 w-full h-20 min-h-[120px] rounded-lg border border-gray-800 bg-gray-100 focus:border-blue-500 focus:ring-blue-500"
                                            required
                                        ></textarea>
                                    </div>
                                    <div class="flex-none">
                                        <div class="w-32 text-center p-3 bg-gray-50 rounded-lg border border-gray-800">
                                            <label class="block text-sm font-medium text-gray-700">Score</label>
                                            <input 
                                                type="number"
                                                :name="`${key}_score`"
                                                x-model.number="scores[key]"
                                                @input="validateScore($event, key)"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                                :min="0"
                                                :max="section.maxScore"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800" x-text="`Out of ${section.maxScore}`"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Assessment Decision -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        <div class="p-6 space-y-6">
                            <!-- General Comments -->
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">General Comments</h3>
                                <p class="mt-1 text-sm text-gray-500">Provide your overall assessment of the research proposal</p>
                                <textarea 
                                    name="general_comments"
                                    class="mt-4 w-full min-h-[120px] rounded-lg border border-gray-800 bg-gray-100 focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Enter your general comments and observations..."
                                    required
                                ></textarea>
                            </div>

                            <!-- Correction Type -->
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Assessment Decision</h3>
                                <p class="mt-1 text-sm text-gray-500">Select one assessment decision (optional)</p>
                                
                                <div class="mt-4 space-y-4">
                                    <template x-for="(type, key) in correctionTypes" :key="key">
                                        <div class="rounded-lg border border-gray-200 overflow-hidden">
                                            <label class="flex items-center p-4 cursor-pointer hover:bg-gray-50"
                                                :class="{ 'bg-blue-50 border-blue-200': selectedCorrection === key }">
                                                <input 
                                                    type="radio"
                                                    name="correction_type"
                                                    :value="key"
                                                    x-model="selectedCorrection"
                                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                                >
                                                <div class="ml-3">
                                                    <div class="font-medium text-gray-900" x-text="type.label"></div>
                                                    <div class="text-sm text-gray-500" x-text="type.description"></div>
                                                </div>
                                            </label>
                                            
                                            <div x-show="selectedCorrection === key"
                                                x-transition
                                                class="border-t border-gray-200 p-4 bg-white">
                                                <textarea 
                                                    name="correction_comments"
                                                    class="w-full min-h-[100px] rounded-lg border border-gray-800 bg-gray-100 focus:border-blue-500 focus:ring-blue-500"
                                                    :placeholder="`${type.commentPlaceholder}...`"
                                                    x-model="correctionComments"
                                                    required
                                                ></textarea>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-right">
                        <button 
                            type="submit"
                            class="inline-flex justify-center py-3 px-6 text-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                            :disabled="submitting"
                        >
                            <span x-show="!submitting">Submit Assessment</span>
                            <span x-show="submitting">Submitting...</span>
                        </button>
                    </div>
                </form>
            </div>            
        </div>

        <!-- Right Panel - Document Preview -->
        <div class="w-full md:w-1/2 h-full flex flex-col bg-gray-50">
            <div class="flex-none bg-white border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Document Preview</h2>
                        <p class="mt-1 text-sm text-gray-500">Article Abstract</p>
                    </div>        
                </div>
            </div>

            <div 
                x-data="documentPreview('<?php echo e(route('reviewer.assessment.abstractpreview', $serial_number)); ?>')"
                x-init="loadAbstract()"
                class="flex-1 overflow-y-auto p-6"
            >
                <template x-if="loading">
                    <div class="flex justify-center items-center h-full">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                    </div>
                </template>

                <template x-if="!loading && abstract">
                    <div class="max-w-3xl mx-auto bg-white shadow p-8">
                        <h1 x-text="abstract.title" class="text-2xl font-bold text-center text-gray-900 mb-6"></h1>
                        
                        <div class="mb-8 text-center">
                            <template x-for="(author, index) in abstract.authors" :key="index">
                                <p class="text-sm text-gray-700" x-text="formatAuthorName(author)"></p>
                            </template>
                        </div>

                        <h2 class="text-lg font-bold text-gray-900 mb-4">ABSTRACT</h2>
                        <p x-text="abstract.content" class="text-gray-700 leading-relaxed text-justify mb-6"></p>

                        <div class="space-y-4">
                            <div>
                                <h3 class="font-bold text-gray-900">Keywords</h3>
                                <p x-text="abstract.keywords || 'Not available'" class="text-gray-700"></p>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Sub-Theme</h3>
                                <p x-text="abstract.sub_theme || 'Not available'" class="text-gray-700"></p>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="!loading && !abstract">
                    <div class="flex flex-col items-center justify-center h-full">
                        <p class="text-red-600 mb-4">Failed to load abstract: <span x-text="error"></span></p>
                        <button @click="loadAbstract()" class="text-blue-600 hover:underline">Retry</button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('assessmentForm', () => ({
        scores: {
            thematic: 0,
            title: 0,
            methodology: 0,
            output: 0,
            objectives: 0
        },
        sections: {
            thematic: { label: 'Research Thematic Area', maxScore: 5 },
            title: { label: 'Research Title', maxScore: 5 },
            objectives: { label: 'Objectives/Aims', maxScore: 5 },
            methodology: { label: 'Methodology', maxScore: 30 },
            output: { label: 'Expected Output', maxScore: 5 }
        },
        correctionTypes: {
            minor: {
                label: 'Minor Corrections',
                description: 'Small changes or clarifications needed',
                commentPlaceholder: 'Describe the minor corrections needed'
            },
            major: {
                label: 'Major Corrections',
                description: 'Significant revisions or rework needed',
                commentPlaceholder: 'Describe the major corrections needed'
            },
            reject: {
                label: 'Reject',
                description: 'The proposal is not suitable for submission',
                commentPlaceholder: 'Provide comments explaining the rejection'
            }
        },
        selectedCorrection: null,
        correctionComments: '',
        submitting: false,

        get totalScore() {
            return Object.values(this.scores).reduce((a, b) => a + b, 0);
        },

        validateScore(event, key) {
            const value = parseInt(event.target.value);
            const maxScore = this.sections[key].maxScore;
            
            if (value < 0) this.scores[key] = 0;
            else if (value > maxScore) this.scores[key] = maxScore;
            else this.scores[key] = value;
        },

        async submitForm(e) {
            this.submitting = true;
            
            try {
                const form = e.target;
                const formData = new FormData(form);
                formData.delete('totalScore');
                
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    window.location.href = data.redirect;
                } else {
                    throw new Error(data.message || 'Submission failed');
                }
            } catch (error) {
                alert('Error submitting form: ' + error.message);
            } finally {
                this.submitting = false;
            }
        }
    }));

    Alpine.data('documentPreview', (apiUrl) => ({
        abstract: null,
        loading: true,
        error: null,

        async loadAbstract() {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await fetch(apiUrl);
                const data = await response.json();
                
                if (!response.ok) throw new Error(data.message || 'Failed to load abstract');
                
                this.abstract = data;
            } catch (error) {
                this.error = error.message;
                this.abstract = null;
            } finally {
                this.loading = false;
            }
        },

        formatAuthorName(author) {
            return [author.first_name, author.middle_name, author.surname]
                .filter(Boolean)
                .join(' ');
        }
    }));
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('reviewer.layouts.reviewer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\email-verification-app\resources\views/reviewer/partials/assessment.blade.php ENDPATH**/ ?>