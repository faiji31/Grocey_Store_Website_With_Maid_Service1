 <div class="container-fluid">
                     <div class="footer">
                        <p>Grocery Store and Maid Service Website.</p>
                     </div>
                  </div>
                  <style>/* Footer Container */
.footer {
    position: relative;
    min-height: 70px;
    background: linear-gradient(135deg, #1a73e8, #0a4c94);
    margin-top: 30px;
    border-radius: 10px;
    width: 100%;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
    overflow: hidden;
}

/* Decorative animated gradient effect */
.footer::before {
    content: "";
    position: absolute;
    top: 0;
    left: -50%;
    width: 200%;
    height: 100%;
    background: linear-gradient(120deg, rgba(255, 255, 255, 0.15), transparent, rgba(255, 255, 255, 0.15));
    animation: shimmer 3s infinite linear;
}

@keyframes shimmer {
    0% { transform: translateX(-50%); }
    100% { transform: translateX(50%); }
}

/* Footer Text */
.footer p {
    margin: 0;
    font-size: 15px;
    font-weight: 400;
    color: #ffffff;
    padding: 25px 15px;
    text-align: center;
    letter-spacing: 0.5px;
}

/* Responsive Styling */
@media (max-width: 576px) {
    .footer p {
        font-size: 13px;
        padding: 20px 10px;
    }
}
</style>