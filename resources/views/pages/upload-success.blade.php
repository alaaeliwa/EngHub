<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />

    <title>Upload Success | EngHub</title>
</head>

<body style="background-color: #f8fafc;">
    <div style="min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 2rem;">
        <div style="width: 100%; max-width: 600px; display: flex; flex-direction: column; align-items: center; text-align: center;">
            
            <!-- Check Icon -->
            <div style="width: 80px; height: 80px; background-color: white; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; justify-content: center; align-items: center; margin-bottom: 1.5rem;">
                <div style="width: 50px; height: 50px; background-color: #10b981; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: white; font-size: 1.5rem;">
                    <i class="fa-solid fa-check"></i>
                </div>
            </div>

            <!-- Header Text -->
            <h1 style="color: var(--primary-dark); font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Material Uploaded Successfully!</h1>
            <p style="color: #64748b; font-size: 1rem; line-height: 1.6; max-width: 450px; margin-bottom: 2rem;">
                Your contribution is being reviewed by our moderators. It will be visible to the community shortly.
            </p>

            <!-- Resource Summary Card -->
            <div style="background-color: white; width: 100%; border-radius: var(--radius-xl); box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; text-align: left; position: relative; overflow: hidden; margin-bottom: 2rem;">
                <!-- Subtle background element in top right -->
                <div style="position: absolute; top: 0; right: 0; width: 60px; height: 60px; background-color: #f1f5f9; border-bottom-left-radius: 100%;"></div>

                <div style="padding: 1.5rem 2rem;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem;">
                        <i class="fa-solid fa-circle-info" style="color: var(--primary); font-size: 0.8rem;"></i>
                        <span style="font-weight: 700; color: var(--primary); font-size: 0.85rem; letter-spacing: 0.5px; text-transform: uppercase;">Resource Summary</span>
                    </div>

                    <div style="display: grid; grid-template-columns: 2fr 2fr 1fr; gap: 1rem;">
                        <div>
                            <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 0.5px;">Title</div>
                            <div style="font-weight: 600; color: var(--primary-dark); font-size: 1rem; line-height: 1.4;">Thermodynamics Lab<br>Report 04</div>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 0.5px;">Course</div>
                            <div style="font-weight: 600; color: var(--primary-dark); font-size: 1rem; line-height: 1.4;">MECH 204: Applied<br>Heat</div>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 0.5px;">File Type</div>
                            <div style="display: flex; align-items: center; gap: 5px; color: #ef4444; font-weight: 600; background: #fef2f2; padding: 4px 8px; border-radius: 4px; display: inline-flex;">
                                <i class="fa-regular fa-file-pdf"></i> PDF
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 1rem; width: 100%; max-width: 500px;">
                <a href="{{ route('dashboard') }}" class="btn" style="flex: 1; text-align: center; text-decoration: none; padding: 1rem; border-radius: var(--radius-sm); font-weight: 600;">Go to Dashboard <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                <a href="{{ route('upload') }}" style="flex: 1; text-align: center; text-decoration: none; padding: 1rem; border: 1px solid #cbd5e1; border-radius: var(--radius-sm); color: #64748b; font-weight: 600; background-color: white; transition: all 0.3s ease;">+ Upload Another Resource</a>
            </div>

        </div>
    </div>
</body>
</html>
