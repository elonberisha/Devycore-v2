<?php
namespace Devycore;

/**
 * Rate Limiting Class
 * IP-based request rate limiting stored in MySQL
 */
class RateLimit {
    private Database $db;
    private int $windowSeconds;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->windowSeconds = (int)($_ENV['RATE_LIMIT_WINDOW'] ?? 600); // 10 minutes default
    }

    /**
     * Check if request is rate limited
     * @param string $endpoint Endpoint identifier (e.g., 'contact', 'discount', 'login')
     * @param string $ipAddress Client IP address
     * @param int $limit Maximum requests per window
     * @return array ['allowed' => bool, 'retry_after' => int|null]
     */
    public function check(string $endpoint, string $ipAddress, int $limit): array {
        $windowStart = date('Y-m-d H:i:s', time() - $this->windowSeconds);

        // Get current count for this IP + endpoint in the window
        $record = $this->db->fetchOne(
            "SELECT request_count, window_start
             FROM rate_limits
             WHERE endpoint = ? AND ip_address = ? AND window_start > ?",
            [$endpoint, $ipAddress, $windowStart]
        );

        if (!$record) {
            // No record found, create new one
            $this->createRecord($endpoint, $ipAddress);
            return ['allowed' => true, 'retry_after' => null];
        }

        $requestCount = (int)$record['request_count'];

        if ($requestCount >= $limit) {
            // Rate limit exceeded
            $retryAfter = $this->calculateRetryAfter($record['window_start']);
            return ['allowed' => false, 'retry_after' => $retryAfter];
        }

        // Increment count
        $this->incrementCount($endpoint, $ipAddress);
        return ['allowed' => true, 'retry_after' => null];
    }

    /**
     * Create new rate limit record
     */
    private function createRecord(string $endpoint, string $ipAddress): void {
        $windowStart = date('Y-m-d H:i:s');

        try {
            $this->db->query(
                "INSERT INTO rate_limits (endpoint, ip_address, request_count, window_start)
                 VALUES (?, ?, 1, ?)
                 ON DUPLICATE KEY UPDATE
                 request_count = request_count + 1,
                 last_request = CURRENT_TIMESTAMP",
                [$endpoint, $ipAddress, $windowStart]
            );
        } catch (\Exception $e) {
            error_log("Failed to create rate limit record: " . $e->getMessage());
        }
    }

    /**
     * Increment request count
     */
    private function incrementCount(string $endpoint, string $ipAddress): void {
        try {
            $this->db->execute(
                "UPDATE rate_limits
                 SET request_count = request_count + 1,
                     last_request = CURRENT_TIMESTAMP
                 WHERE endpoint = ? AND ip_address = ?",
                [$endpoint, $ipAddress]
            );
        } catch (\Exception $e) {
            error_log("Failed to increment rate limit count: " . $e->getMessage());
        }
    }

    /**
     * Calculate seconds until retry is allowed
     */
    private function calculateRetryAfter(string $windowStart): int {
        $windowStartTimestamp = strtotime($windowStart);
        $windowEnd = $windowStartTimestamp + $this->windowSeconds;
        $now = time();
        $retryAfter = max(0, $windowEnd - $now);
        return $retryAfter;
    }

    /**
     * Cleanup old rate limit records
     * Should be called periodically (e.g., via cron)
     */
    public function cleanup(): int {
        $cutoff = date('Y-m-d H:i:s', time() - ($this->windowSeconds * 2));
        return $this->db->execute(
            "DELETE FROM rate_limits WHERE window_start < ?",
            [$cutoff]
        );
    }

    /**
     * Reset rate limit for specific IP + endpoint
     * @param string $endpoint
     * @param string $ipAddress
     * @return bool
     */
    public function reset(string $endpoint, string $ipAddress): bool {
        $affected = $this->db->execute(
            "DELETE FROM rate_limits WHERE endpoint = ? AND ip_address = ?",
            [$endpoint, $ipAddress]
        );
        return $affected > 0;
    }

    /**
     * Get current rate limit status
     * @param string $endpoint
     * @param string $ipAddress
     * @return array ['count' => int, 'window_start' => string]
     */
    public function getStatus(string $endpoint, string $ipAddress): array {
        $windowStart = date('Y-m-d H:i:s', time() - $this->windowSeconds);

        $record = $this->db->fetchOne(
            "SELECT request_count, window_start
             FROM rate_limits
             WHERE endpoint = ? AND ip_address = ? AND window_start > ?",
            [$endpoint, $ipAddress, $windowStart]
        );

        if (!$record) {
            return ['count' => 0, 'window_start' => date('Y-m-d H:i:s')];
        }

        return [
            'count' => (int)$record['request_count'],
            'window_start' => $record['window_start']
        ];
    }
}
