<x-app-layout>

    @if(auth()->user()->role == "Super Admin")

    <h2 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-600 md:text-2xl dark:text-white">Welcome, System Admin!</h2>
    <p class="mb-3 text-gray-500 dark:text-gray-400">We are thrilled to welcome you on board as the Administrator of the system. As the Admin, you are entrusted with the highest level of access and control over all system features and functionalities. This role places you at the heart of the platform's operation, giving you the authority and responsibility to manage, monitor, and optimize every aspect of the system.</p>

    <p class="mb-3 text-gray-500 dark:text-gray-400">Your duties will include overseeing the overall health and performance of the platform, ensuring that it runs efficiently, securely, and reliably. You'll be responsible for configuring and maintaining key system settings, managing user roles and permissions, and troubleshooting issues to ensure smooth, uninterrupted service. Your expertise will play a critical role in the detection and mitigation of security risks, safeguarding the integrity of the platform and the data within it.</p>

    <p class="mb-3 text-gray-500 dark:text-gray-400">In addition to system management, you will be tasked with staying up-to-date with platform updates, enhancements, and new features, ensuring that the system evolves to meet both current and future needs. Your role is vital not only in maintaining operational excellence but also in fostering a secure and user-friendly environment for everyone who relies on the platform.</p>

    <p class="mb-3 text-gray-500 dark:text-gray-400">As the Administrator, you will have access to powerful tools and resources that enable you to make informed decisions and implement best practices in system administration. Your leadership will help guide the platform toward its highest potential, ensuring it remains a trusted and reliable resource for all users. Your contribution is key to the ongoing success and growth of the system, and we look forward to the impact you will make in this important role.</p>

    <br>

    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Top function:</h2>
    <ol class="max-w space-y-1 text-gray-500 list-decimal list-inside dark:text-gray-400">
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">User Management: </span> Add, update, or remove users and assign roles to control who can access various sections of the system.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Data Security:</span> Monitor user access, enforce security protocols, and ensure that sensitive data is protected.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Analytics & Reports:</span> View and analyze system logs, user activity, and generate performance reports to ensure smooth operation.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Troubleshooting & Support:</span> Resolve any system issues, assist users with their queries, and ensure that the platform is always performing at its best.
        </li>
    </ol>

    <br>

    <p class="mb-3 mt-3 text-gray-500 dark:text-gray-400">Your actions help ensure that our system runs seamlessly for all users, and your decisions have a direct impact on the system's functionality and performance. If you need assistance, support documentation and a team of experts are always here to help. We trust that you’ll guide the system with care and expertise.</p>

    @endif


    @if(auth()->user()->role == "Admin")

    <h2 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-600 md:text-2xl dark:text-white">Welcome, Admin!</h2>
    <p class="mb-3 text-gray-500 dark:text-gray-400">We are thrilled to welcome you on board as the Administrator of the system. As the Admin, you are entrusted with the highest level of access and control over all system features and functionalities. This role places you at the heart of the platform's operation, giving you the authority and responsibility to manage, monitor, and optimize every aspect of the system.</p>

    <p class="mb-3 text-gray-500 dark:text-gray-400">Your duties will include overseeing the overall health and performance of the platform, ensuring that it runs efficiently, securely, and reliably. You'll be responsible for configuring and maintaining key system settings, managing user roles and permissions, and troubleshooting issues to ensure smooth, uninterrupted service. Your expertise will play a critical role in the detection and mitigation of security risks, safeguarding the integrity of the platform and the data within it.</p>

    <p class="mb-3 text-gray-500 dark:text-gray-400">In addition to system management, you will be tasked with staying up-to-date with platform updates, enhancements, and new features, ensuring that the system evolves to meet both current and future needs. Your role is vital not only in maintaining operational excellence but also in fostering a secure and user-friendly environment for everyone who relies on the platform.</p>

    <p class="mb-3 text-gray-500 dark:text-gray-400">As the Administrator, you will have access to powerful tools and resources that enable you to make informed decisions and implement best practices in system administration. Your leadership will help guide the platform toward its highest potential, ensuring it remains a trusted and reliable resource for all users. Your contribution is key to the ongoing success and growth of the system, and we look forward to the impact you will make in this important role.</p>

    <br>

    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Top function:</h2>
    <ol class="max-w space-y-1 text-gray-500 list-decimal list-inside dark:text-gray-400">
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">User Management: </span> Add, update, or remove users and assign roles to control who can access various sections of the system.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Data Security:</span> Monitor user access, enforce security protocols, and ensure that sensitive data is protected.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Analytics & Reports:</span> View and analyze system logs, user activity, and generate performance reports to ensure smooth operation.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Troubleshooting & Support:</span> Resolve any system issues, assist users with their queries, and ensure that the platform is always performing at its best.
        </li>
    </ol>

    <br>

    <p class="mb-3 mt-3 text-gray-500 dark:text-gray-400">Your actions help ensure that our system runs seamlessly for all users, and your decisions have a direct impact on the system's functionality and performance. If you need assistance, support documentation and a team of experts are always here to help. We trust that you’ll guide the system with care and expertise.</p>

    @endif



    @if(auth()->user()->role == "Encoder")

    <h2 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-600 md:text-2xl dark:text-white">Welcome, Encoder!</h2>
    <p class="mb-3 text-gray-500 dark:text-gray-400">Thank you for taking on the important role of Encoding. Your job is crucial to the system’s success, as you're responsible for transforming raw data into the correct format for processing. Whether you're working with input forms, batch data, or complex datasets, your attention to detail ensures that all data is processed smoothly and without error.</p>

    <br>

    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Your key responsibilities include:</h2>
    <ol class="max-w space-y-1 text-gray-500 list-decimal list-inside dark:text-gray-400">
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Data Entry & Formatting: </span> You will input data into the system and ensure that it adheres to the required format and standards. Accuracy and consistency are vital to avoid errors later in the process.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Data Validation (Pre-Process):</span> While encoding, you will cross-check the data to make sure it's valid, ensuring that no unnecessary mistakes are introduced at the entry stage.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Error Resolution:</span> If you encounter formatting or entry issues, you'll need to troubleshoot and correct them before the data is passed on to the next stage.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Performance Optimization:</span> Your role is to work quickly and efficiently, making sure that the encoding process is as smooth as possible to avoid delays down the line.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Collaboration:</span> Communicate with other team members, especially Validators, to ensure that the data you’ve encoded is ready for validation and final processing.
        </li>
    </ol>

    <br>

    <p class="mb-3 mt-3 text-gray-500 dark:text-gray-400">You are the gatekeeper of clean and correct data, and your work lays the foundation for everything that follows. If you ever encounter challenges or need guidance, you can always count on our support resources. Your efforts directly impact the quality and speed of the system, so your role is incredibly valuable.</p>
    @endif




    @if(auth()->user()->role == "Validator")

    <h2 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-600 md:text-2xl dark:text-white">Welcome, Validator!</h2>
    <p class="mb-3 text-gray-500 dark:text-gray-400">As a Validator, you play a key role in ensuring the accuracy and integrity of the data that flows through the system. Your job is to meticulously check the information encoded by the team and verify that it meets all established standards before it moves on to the next stage.</p>

    <br>

    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Key responsibilities you will manage:</h2>
    <ol class="max-w space-y-1 text-gray-500 list-decimal list-inside dark:text-gray-400">
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Data Review & Verification:</span> You will examine data entries to ensure that they are accurate, complete, and conform to required formats and standards.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Compliance Monitoring:</span> Ensuring that all data complies with regulatory and internal standards is a major part of your role. This includes checking for any discrepancies, errors, or incomplete entries that could affect the system's integrity.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Error Detection & Resolution:</span> If you find any issues with the data, you’ll work with the Encoder to resolve them, ensuring that only valid data is passed forward.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Quality Assurance:</span> You are responsible for maintaining the quality of the data and identifying areas where improvements can be made in the process.
        </li>
    </ol>

    <br>

    <p class="mb-3 mt-3 text-gray-500 dark:text-gray-400">Your meticulous approach helps protect the system from potential data corruption and ensures that every piece of information meets the highest standards. You are the final check in our data processing workflow, and your attention to detail keeps everything running smoothly. If you need any assistance or encounter challenges, feel free to reach out for support. The accuracy and consistency of the data are entirely dependent on your careful validation process.</p>

    @endif


    @if(auth()->user()->role == "Scanner")

    <h2 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-600 md:text-2xl dark:text-white">Welcome, QR Code Scanner!</h2>
    <p class="mb-3 text-gray-500 dark:text-gray-400">As a QR Code Scanner, you play an essential role in capturing, decoding, and processing the valuable data embedded in QR codes. Your task is to ensure that QR codes are scanned accurately and the extracted information is correctly interpreted and routed to the next step of the process.</p>

    <br>

    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Key responsibilities you will manage:</h2>
    <ol class="max-w space-y-1 text-gray-500 list-decimal list-inside dark:text-gray-400">
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">QR Code Scanning:</span> You will use the designated scanner or mobile device to capture QR codes, ensuring accurate and timely scans.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Data Decoding & Extraction:</span> Once scanned, you will extract and decode the data from QR codes, converting it into usable information for the system.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Data Routing:</span> After decoding, you will forward the data to the appropriate systems or departments for processing, ensuring the smooth flow of information.
        </li>
        <li>
            <span class="font-semibold text-gray-900 dark:text-white">Error Handling & Reporting:</span> If the QR code cannot be read or the data is invalid, you will report the issue and take corrective actions, working closely with the team to resolve any issues.
        </li>
    </ol>

    <br>

    <p class="mb-3 mt-3 text-gray-500 dark:text-gray-400">Your precision in scanning and decoding ensures that the data is transmitted accurately through the system. You are the first line of data input, and your work directly impacts the success of subsequent processes. Should you face any challenges, don't hesitate to seek support. Your attention to detail is crucial for maintaining the smooth operation of the workflow.</p>


    @endif

</x-app-layout>