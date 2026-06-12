

<?php $__env->startSection('title', __('Interview Prep') . ' - LookForJob'); ?>

<?php $__env->startSection('content'); ?>
<section class="min-h-screen bg-gradient-to-br from-emerald-50 dark:from-emerald-950/40 via-white dark:via-slate-950 to-teal-50 dark:to-teal-950/40 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-12 text-center">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-700 dark:text-emerald-400 mb-4">
                <i data-lucide="mic" class="w-8 h-8"></i>
            </div>
            <h1 class="text-4xl font-bold text-slate-900 dark:text-white"><?php echo e(__('Interactive AI Interview')); ?></h1>
            <p class="text-slate-600 dark:text-slate-400 mt-2"><?php echo e(__('Practice speaking with our AI interviewer')); ?></p>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 p-8">
            <!-- Setup Form -->
            <div id="setupSection">
                <form id="startForm" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Job Title</label>
                        <input type="text" id="jobTitle" required placeholder="e.g., Frontend Developer" 
                               class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-900 dark:text-white">
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2">
                        <i data-lucide="play" class="w-5 h-5"></i> Start Interview
                    </button>
                </form>
            </div>

            <!-- Interview Area -->
            <div id="interviewSection" class="hidden flex flex-col h-[500px]">
                <div id="chatHistory" class="flex-1 overflow-y-auto space-y-4 mb-6 pr-2">
                    <!-- Chat bubbles go here -->
                </div>
                
                <div class="flex items-center gap-4">
                    <button id="micBtn" type="button" class="w-14 h-14 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 transition-colors shadow-sm">
                        <i data-lucide="mic" class="w-6 h-6" id="micIcon"></i>
                    </button>
                    <div class="flex-1">
                        <input type="text" id="transcriptInput" placeholder="Your voice will appear here..." 
                               class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white focus:outline-none">
                    </div>
                    <button id="sendBtn" type="button" class="w-14 h-14 rounded-xl bg-emerald-600 hover:bg-emerald-700 flex items-center justify-center text-white transition-colors shadow-sm disabled:opacity-50">
                        <i data-lucide="send" class="w-5 h-5"></i>
                    </button>
                </div>
                <p id="statusText" class="text-center text-sm text-slate-500 mt-2">Click mic to speak</p>
            </div>
        </div>
    </div>
</section>

<script>
    const appLocale = "<?php echo e(app()->getLocale()); ?>";
    let chatHistory = [];
    let jobTitle = "";
    let interviewLang = appLocale === 'id' ? 'id-ID' : 'en-US';
    
    // Web Speech API
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    let recognition;
    let isRecording = false;

    if (SpeechRecognition) {
        recognition = new SpeechRecognition();
        recognition.continuous = false;
        recognition.interimResults = true;

        recognition.onstart = function() {
            isRecording = true;
            document.getElementById('micBtn').classList.add('bg-red-500', 'text-white', 'animate-pulse');
            document.getElementById('micBtn').classList.remove('bg-slate-100', 'text-slate-600');
            document.getElementById('statusText').innerText = "Listening...";
        };

        recognition.onresult = function(event) {
            let finalTranscript = '';
            for (let i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    finalTranscript += event.results[i][0].transcript;
                }
            }
            if (finalTranscript) {
                document.getElementById('transcriptInput').value = finalTranscript;
                recognition.stop();
                sendMessage(finalTranscript);
            }
        };

        recognition.onerror = function(event) {
            console.error(event.error);
            stopRecordingUI();
            document.getElementById('statusText').innerText = "Error listening. Please try again.";
        };

        recognition.onend = function() {
            stopRecordingUI();
        };
    } else {
        console.warn("Native Speech Recognition not supported. Falling back to MediaRecorder + Backend API.");
    }

    let mediaRecorder;
    let audioChunks = [];

    function stopRecordingUI() {
        isRecording = false;
        document.getElementById('micBtn').classList.remove('bg-red-500', 'text-white', 'animate-pulse');
        document.getElementById('micBtn').classList.add('bg-slate-100', 'text-slate-600');
        document.getElementById('statusText').innerText = "Click mic to speak";
    }

    document.getElementById('micBtn').addEventListener('click', async () => {
        if (isRecording) {
            if (recognition) {
                recognition.stop();
            } else if (mediaRecorder) {
                mediaRecorder.stop();
            }
        } else {
            document.getElementById('transcriptInput').value = '';
            
            if (recognition) {
                recognition.lang = interviewLang;
                recognition.start();
            } else {
                // Fallback to MediaRecorder for Firefox
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    mediaRecorder = new MediaRecorder(stream);
                    audioChunks = [];

                    mediaRecorder.ondataavailable = event => {
                        audioChunks.push(event.data);
                    };

                    mediaRecorder.onstop = async () => {
                        stopRecordingUI();
                        document.getElementById('statusText').innerText = "Transcribing audio...";
                        
                        const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                        const formData = new FormData();
                        formData.append('audio', audioBlob);
                        formData.append('language', interviewLang);

                        try {
                            const response = await fetch('/api/interview/transcribe', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                },
                                body: formData
                            });

                            const result = await response.json();
                            if (result.success && result.text) {
                                document.getElementById('transcriptInput').value = result.text;
                                sendMessage(result.text);
                            } else {
                                document.getElementById('statusText').innerText = result.message || "Failed to transcribe audio.";
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            document.getElementById('statusText').innerText = "Transcription error.";
                        }
                    };

                    mediaRecorder.start();
                    isRecording = true;
                    document.getElementById('micBtn').classList.add('bg-red-500', 'text-white', 'animate-pulse');
                    document.getElementById('micBtn').classList.remove('bg-slate-100', 'text-slate-600');
                    document.getElementById('statusText').innerText = "Recording... Click to stop.";
                    
                } catch (err) {
                    console.error("Microphone access denied:", err);
                    alert("Gagal mengakses mikrofon. Pastikan Anda memberikan izin akses mikrofon.");
                }
            }
        }
    });

    document.getElementById('startForm').addEventListener('submit', (e) => {
        e.preventDefault();
        jobTitle = document.getElementById('jobTitle').value;
        
        document.getElementById('setupSection').classList.add('hidden');
        document.getElementById('interviewSection').classList.remove('hidden');
        
        const initialGreeting = interviewLang === 'en-US' 
            ? `Hello! Let's start the interview for the ${jobTitle} position. Please introduce yourself and tell me a bit about your experience.`
            : `Halo! Mari kita mulai wawancara untuk posisi ${jobTitle}. Silakan perkenalkan diri Anda dan ceritakan sedikit pengalaman Anda.`;
            
        addChatBubble('ai', initialGreeting);
        speakText(initialGreeting);
    });

    document.getElementById('sendBtn').addEventListener('click', () => {
        const input = document.getElementById('transcriptInput');
        sendMessage(input.value);
    });

    document.getElementById('transcriptInput').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage(e.target.value);
        }
    });

    async function sendMessage(text) {
        if (!text.trim()) return;
        
        document.getElementById('transcriptInput').value = '';
        addChatBubble('user', text);
        
        document.getElementById('statusText').innerText = "AI is thinking...";
        
        try {
            const response = await fetch('/api/interview/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({
                    job_title: jobTitle,
                    user_message: text,
                    chat_history: chatHistory,
                    language: interviewLang
                })
            });

            const result = await response.json();
            
            if (result.success) {
                const aiResponse = result.ai_response;
                chatHistory = result.chat_history;
                addChatBubble('ai', aiResponse);
                speakText(aiResponse);
                document.getElementById('statusText').innerText = "Click mic to speak";
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('statusText').innerText = "Error. Please try again.";
        }
    }

    function addChatBubble(sender, text) {
        const container = document.getElementById('chatHistory');
        const bubble = document.createElement('div');
        bubble.className = `flex w-full ${sender === 'user' ? 'justify-end' : 'justify-start'}`;
        
        const bgClass = sender === 'user' ? 'bg-emerald-600 text-white rounded-br-none' : 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white rounded-bl-none';
        
        bubble.innerHTML = `
            <div class="max-w-[80%] p-4 rounded-2xl ${bgClass} shadow-sm">
                <p class="text-sm md:text-base leading-relaxed">${text}</p>
            </div>
        `;
        container.appendChild(bubble);
        container.scrollTop = container.scrollHeight;
    }

    function speakText(text) {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = interviewLang;
            utterance.rate = 1.0;
            window.speechSynthesis.speak(utterance);
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LookForJob\resources\views/career-tools/interview-prep.blade.php ENDPATH**/ ?>