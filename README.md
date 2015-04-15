# user-agents.json
This is a JSON file of User-Agent regular expressions,
and an implementation which can parse this file and determine the parameters of the user-agent.

By separating the rules from the logic which processes the rules,
the rules file can be easily and quickly updated, and the logic can be condigured
to download the rules file from a central location at regular intervals.

## Implementations
At present only a PHP implementation is provided, but implementations would not be difficult to create
in other languages (pull requests welcome).

This current implementation does not downlaod the file from a central server, but this would not be
difficult to implement either in the calling code or by extending the implementation (pull requests welcome).

## Adding rules
Matching begins with an empty state object.

Rules are a PCRE regular expression. If the rule matches, then the parameters for that rule are applied to the
current state object.

Parameters can contain subexpressions in the form $1, $2, etc.

Rules can be nested. If a rule matches, all of it's sub-rules are tested as well.
